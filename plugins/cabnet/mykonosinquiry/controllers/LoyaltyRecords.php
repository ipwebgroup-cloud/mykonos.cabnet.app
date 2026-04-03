<?php namespace Cabnet\MykonosInquiry\Controllers;

use BackendAuth;
use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;
use Cabnet\MykonosInquiry\Models\LoyaltyRecord;
use Flash;

class LoyaltyRecords extends Controller
{
    public $implement = [ListController::class, FormController::class];

    public $listConfig = 'config_list.yaml';

    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['cabnet.mykonosinquiry.manage_loyalty_continuity'];

    protected ?string $pendingNewTouchpointNote = null;

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Cabnet.MykonosInquiry', 'mykonosinquiry', 'loyaltyrecords');
    }

    public function index()
    {
        $this->pageTitle = 'Loyalty Continuity';

        $this->asExtension('ListController')->index();
    }

    public function create()
    {
        $this->pageTitle = 'Create Loyalty Record';

        $this->asExtension('FormController')->create();
    }

    public function update($recordId = null, $context = null)
    {
        $this->asExtension('FormController')->update($recordId, $context);

        $record = $recordId ? LoyaltyRecord::find($recordId) : null;
        $reference = $record && $record->request_reference ? $record->request_reference : ($record->guest_name ?? 'Update Loyalty Record');

        $this->pageTitle = 'Loyalty · ' . $reference;
    }

    public function formBeforeSave($model): void
    {
        $data = (array) post('LoyaltyRecord', []);
        $note = trim((string) ($data['new_touchpoint_note'] ?? post('new_touchpoint_note', '')));
        $this->pendingNewTouchpointNote = $note !== '' ? $note : null;

        if (empty($model->continuity_status)) {
            $model->continuity_status = 'active_retention';
        }

        if (empty($model->loyalty_stage)) {
            $model->loyalty_stage = 'review';
        }

        if (empty($model->return_value_tier)) {
            $model->return_value_tier = 'watch';
        }
    }

    public function formAfterSave($model): void
    {
        if (!$this->pendingNewTouchpointNote) {
            return;
        }

        $model->appendTouchpoint('internal', $this->pendingNewTouchpointNote, $this->getOperatorName());
        Flash::success('Loyalty touchpoint saved.');

        $this->pendingNewTouchpointNote = null;
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
}
