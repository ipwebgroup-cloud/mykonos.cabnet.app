<?php namespace Cabnet\MykonosInquiry\Controllers;

use BackendAuth;
use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;
use Cabnet\MykonosInquiry\Models\Inquiry;
use Cabnet\MykonosInquiry\Models\InquiryNote;
use Carbon\Carbon;
use Flash;

class Inquiries extends Controller
{
    public $implement = [ListController::class, FormController::class];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['cabnet.mykonosinquiry.manage_inquiries'];

    protected ?string $pendingNewInternalNote = null;

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Cabnet.MykonosInquiry', 'mykonosinquiry', 'inquiries');
    }


    public function index()
    {
        $this->pageTitle = 'Mykonos Inquiries';
        $this->asExtension('ListController')->index();
    }

    public function create()
    {
        $this->pageTitle = 'Create Inquiry';
        $this->asExtension('FormController')->create();
    }

    public function update($recordId = null, $context = null)
    {
        if ($recordId && request()->isMethod('post') && post('_quick_action')) {
            return $this->dispatchQuickActionFromUpdate($recordId);
        }

        $this->asExtension('FormController')->update($recordId, $context);

        if (!$this->formWidget && $recordId) {
            $model = Inquiry::findOrFail($recordId);
            $this->asExtension('FormController')->initForm($model, $context);
        }

        $inquiry = $recordId ? Inquiry::find($recordId) : null;
        $reference = $inquiry && $inquiry->request_reference ? $inquiry->request_reference : 'Update Inquiry';
        $this->pageTitle = 'Inquiry · ' . $reference;
    }

    public function formBeforeSave($model): void
    {
        $data = (array) post('Inquiry', []);
        $note = trim((string) ($data['new_internal_note'] ?? post('new_internal_note', '')));
        $this->pendingNewInternalNote = $note !== '' ? $note : null;

        if (empty($model->priority)) {
            $model->priority = 'normal';
        }
    }

    public function formAfterSave($model): void
    {
        if (!$this->pendingNewInternalNote) {
            return;
        }

        $note = new InquiryNote();
        $note->inquiry_id = $model->id;
        $note->note_type = 'internal';
        $note->author_name = $this->getOperatorName();
        $note->body = $this->pendingNewInternalNote;
        $note->is_internal = true;
        $note->save();

        $this->pendingNewInternalNote = null;
    }

    public function assignToMe($recordId = null)
    {
        return $this->runQuickAction($recordId, function (Inquiry $inquiry): bool {
            $changed = false;
            $operator = $this->getOperatorName();

            if ($inquiry->owner_name !== $operator) {
                $inquiry->owner_name = $operator;
                $changed = true;
            }

            if ($inquiry->status === 'new') {
                $inquiry->status = 'reviewed';
                $changed = true;
            }

            return $changed;
        }, 'Inquiry assigned to you.', 'Quick action: assigned to current operator.');
    }

    public function markContacted($recordId = null)
    {
        return $this->runQuickAction($recordId, function (Inquiry $inquiry): bool {
            $changed = false;
            $operator = $this->getOperatorName();
            $now = Carbon::now();

            if ($inquiry->owner_name !== $operator) {
                $inquiry->owner_name = $operator;
                $changed = true;
            }

            $wasClosed = $this->isClosedStatus($inquiry->status);

            if ($inquiry->status !== 'contacted') {
                $inquiry->status = 'contacted';
                $changed = true;
            }

            if (!$inquiry->last_contacted_at || $inquiry->last_contacted_at->format('Y-m-d H:i:s') !== $now->format('Y-m-d H:i:s')) {
                $inquiry->last_contacted_at = $now;
                $changed = true;
            }

            if ($wasClosed && !empty($inquiry->closed_reason)) {
                $inquiry->closed_reason = null;
                $changed = true;
            }

            return $changed;
        }, 'Inquiry marked as contacted.', 'Quick action: marked inquiry as contacted.');
    }

    public function scheduleTomorrow($recordId = null)
    {
        return $this->scheduleFollowUp($recordId, Carbon::tomorrow(), 'Follow-up set for tomorrow.', 'Quick action: follow-up scheduled for tomorrow.');
    }

    public function scheduleInThreeDays($recordId = null)
    {
        return $this->scheduleFollowUp($recordId, Carbon::today()->addDays(3), 'Follow-up set for three days from now.', 'Quick action: follow-up scheduled for three days from now.');
    }

    public function reopenInquiry($recordId = null)
    {
        return $this->runQuickAction($recordId, function (Inquiry $inquiry): bool {
            $changed = false;

            if ($this->isClosedStatus($inquiry->status)) {
                $inquiry->status = 'reviewed';
                $changed = true;
            }

            if (!empty($inquiry->closed_reason)) {
                $inquiry->closed_reason = null;
                $changed = true;
            }

            return $changed;
        }, 'Inquiry reopened.', 'Quick action: reopened inquiry for active handling.');
    }

    public function closeWon($recordId = null)
    {
        return $this->closeInquiry($recordId, 'closed_won', 'Inquiry closed as won.', 'Quick action: marked inquiry as closed won.');
    }

    public function closeLost($recordId = null)
    {
        return $this->closeInquiry($recordId, 'closed_lost', 'Inquiry closed as lost.', 'Quick action: marked inquiry as closed lost.');
    }


    protected function dispatchQuickActionFromUpdate($recordId)
    {
        $action = trim((string) post('_quick_action'));

        switch ($action) {
            case 'assign_to_me':
                return $this->assignToMe($recordId);
            case 'mark_contacted':
                return $this->markContacted($recordId);
            case 'follow_up_tomorrow':
                return $this->scheduleTomorrow($recordId);
            case 'follow_up_plus_three':
                return $this->scheduleInThreeDays($recordId);
            case 'reopen_inquiry':
                return $this->reopenInquiry($recordId);
            case 'close_won':
                return $this->closeWon($recordId);
            case 'close_lost':
                return $this->closeLost($recordId);
            default:
                Flash::warning('Unknown quick action.');
                return redirect(\Backend::url('cabnet/mykonosinquiry/inquiries/update/' . $recordId));
        }
    }

    protected function scheduleFollowUp($recordId, Carbon $date, string $successMessage, string $auditNote)
    {
        return $this->runQuickAction($recordId, function (Inquiry $inquiry) use ($date): bool {
            $changed = false;
            $operator = $this->getOperatorName();
            $targetDate = $date->copy()->startOfDay();

            if ($inquiry->owner_name !== $operator) {
                $inquiry->owner_name = $operator;
                $changed = true;
            }

            if (!$inquiry->follow_up_date || $inquiry->follow_up_date->format('Y-m-d') !== $targetDate->format('Y-m-d')) {
                $inquiry->follow_up_date = $targetDate;
                $changed = true;
            }

            if ($inquiry->status === 'new') {
                $inquiry->status = 'reviewed';
                $changed = true;
            }

            return $changed;
        }, $successMessage, $auditNote);
    }

    protected function closeInquiry($recordId, string $status, string $successMessage, string $auditNote)
    {
        return $this->runQuickAction($recordId, function (Inquiry $inquiry) use ($status): bool {
            $changed = false;
            $operator = $this->getOperatorName();

            if ($inquiry->owner_name !== $operator) {
                $inquiry->owner_name = $operator;
                $changed = true;
            }

            if ($inquiry->status !== $status) {
                $inquiry->status = $status;
                $changed = true;
            }

            if (empty($inquiry->closed_reason)) {
                $inquiry->closed_reason = $status === 'closed_won'
                    ? 'Closed by quick action as won.'
                    : 'Closed by quick action as lost.';
                $changed = true;
            }

            return $changed;
        }, $successMessage, $auditNote);
    }

    protected function runQuickAction($recordId, callable $mutator, string $successMessage, string $auditNote)
    {
        $inquiry = Inquiry::findOrFail($recordId);
        $changed = (bool) $mutator($inquiry);

        if ($changed) {
            $inquiry->save();
            $this->appendSystemNote($inquiry, $auditNote);
            Flash::success($successMessage);
        } else {
            Flash::info('No workflow change was needed.');
        }

        return redirect(\Backend::url('cabnet/mykonosinquiry/inquiries/update/' . $inquiry->id));
    }

    protected function appendSystemNote(Inquiry $inquiry, string $body): void
    {
        $note = new InquiryNote();
        $note->inquiry_id = $inquiry->id;
        $note->note_type = 'system';
        $note->author_name = $this->getOperatorName();
        $note->body = $body;
        $note->is_internal = true;
        $note->save();
    }

    protected function getOperatorName(): string
    {
        $user = BackendAuth::getUser();
        if (!$user) {
            return 'Operator';
        }

        $author = trim((string) (($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
        if ($author === '') {
            $author = $user->login ?? 'Operator';
        }

        return $author;
    }

    protected function isClosedStatus(?string $status): bool
    {
        return in_array((string) $status, ['closed_won', 'closed_lost', 'spam', 'closed'], true);
    }
}
