<?php namespace Cabnet\MykonosInquiry\Controllers;

use BackendAuth;
use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;
use Cabnet\MykonosInquiry\Models\LoyaltyRecord;
use Carbon\Carbon;
use Flash;

class LoyaltyRecords extends Controller
{
    public $implement = [ListController::class, FormController::class];

    public $listConfig = 'config_list.yaml';

    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['cabnet.mykonosinquiry.manage_loyalty_continuity'];

    protected array $pendingTouchpointEntry = [];

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
        if ($recordId && request()->isMethod('post') && post('_loyalty_action')) {
            return $this->dispatchContinuityActionFromUpdate($recordId);
        }

        $this->asExtension('FormController')->update($recordId, $context);

        $record = $recordId ? LoyaltyRecord::find($recordId) : null;
        $reference = $record && $record->request_reference ? $record->request_reference : ($record->guest_name ?? 'Update Loyalty Record');

        $this->pageTitle = 'Loyalty · ' . $reference;
    }

    public function formExtendFields($form): void
    {
        $model = $form->model;

        if (!$model instanceof LoyaltyRecord) {
            return;
        }

        $form->addTabFields([
            'transfer_audit_panel' => [
                'label'   => 'Transfer Audit',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_transfer_audit_panel.htm',
                'tab'     => 'Overview',
                'span'    => 'full',
                'comment' => 'Read-only carry-over audit from the source inquiry into the loyalty record.',
            ],
            'retention_packet_overview_panel' => [
                'label'   => 'Retention Packet Overview',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_retention_packet_overview_panel.htm',
                'tab'     => 'Overview',
                'span'    => 'full',
                'comment' => 'At-a-glance packet framing for retention, reactivation, referral, or return-value stewardship.',
            ],
            'continuity_evidence_frame_panel' => [
                'label'   => 'Continuity Evidence Frame',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_evidence_frame_panel.htm',
                'tab'     => 'Overview',
                'span'    => 'full',
                'comment' => 'Readable rationale showing why this record belongs in loyalty continuity and what evidence supports that posture.',
            ],
            'record_detail_structure_panel' => [
                'label'   => 'Record Detail Structure',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_record_detail_structure_panel.htm',
                'tab'     => 'Workspace',
                'span'    => 'full',
                'comment' => 'Read-only structure check so the continuity record stays narrow, owned, and operationally useful.',
            ],
            'continuity_packet_actions_panel' => [
                'label'   => 'Continuity Packet Actions',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_packet_actions_panel.htm',
                'tab'     => 'Workspace',
                'span'    => 'full',
                'comment' => 'Prepare a clean operator brief for reactivation, referral-safe follow-up, return-value stewardship, or review without widening into automation.',
            ],
            'continuity_command_deck_panel' => [
                'label'   => 'Continuity Command Deck',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_command_deck_panel.htm',
                'tab'     => 'Workspace',
                'span'    => 'full',
                'comment' => 'Sanctioned continuity actions that keep retention work narrow, visible, and operator-owned.',
            ],
            'live_touchpoint_capture_panel' => [
                'label'   => 'Live Touchpoint Capture',
                'type'    => 'partial',
                'path'    => '~/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_live_touchpoint_capture_panel.htm',
                'tab'     => 'History',
                'span'    => 'full',
                'comment' => 'Structured first-wave touchpoint entry aligned to the live loyalty ledger.',
            ],
        ]);
    }

    public function formBeforeSave($model): void
    {
        $touchpointEntry = $this->captureTouchpointEntryFromPost();
        $this->pendingTouchpointEntry = $touchpointEntry;

        if (empty($model->continuity_status)) {
            $model->continuity_status = 'active_retention';
        }

        if (empty($model->loyalty_stage)) {
            $model->loyalty_stage = 'review';
        }

        if (empty($model->return_value_tier)) {
            $model->return_value_tier = 'watch';
        }

        if (empty($model->owner_name)) {
            $model->owner_name = $this->getOperatorName();
        }

        if (!empty($touchpointEntry['touchpoint_at'])) {
            $model->last_retention_contact_at = $touchpointEntry['touchpoint_at'];
        }

        if (!empty($touchpointEntry['next_step_at'])) {
            $model->next_review_at = $touchpointEntry['next_step_at'];
        }
    }

    public function formAfterSave($model): void
    {
        if (empty($this->pendingTouchpointEntry)) {
            return;
        }

        $entry = $this->pendingTouchpointEntry;
        $payload = [
            'entry_mode' => 'live_touchpoint_capture',
            'captured_from' => 'loyalty_record_update',
            'continuity_status_snapshot' => $model->continuity_status,
            'loyalty_stage_snapshot' => $model->loyalty_stage,
            'return_value_tier_snapshot' => $model->return_value_tier,
            'referral_ready_snapshot' => (bool) $model->referral_ready,
        ];

        $model->appendTouchpoint(
            $entry['touchpoint_type'],
            $entry['body'],
            $entry['author_name'],
            [
                'touchpoint_channel' => $entry['touchpoint_channel'],
                'touchpoint_outcome' => $entry['touchpoint_outcome'],
                'touchpoint_at' => $entry['touchpoint_at'],
                'next_step_at' => $entry['next_step_at'],
                'reference_code' => $model->request_reference,
                'is_internal' => $entry['is_internal'],
                'payload_json' => $payload,
            ]
        );

        Flash::success('Loyalty touchpoint saved with structured continuity details.');
        $this->pendingTouchpointEntry = [];
    }

    protected function dispatchContinuityActionFromUpdate($recordId)
    {
        $action = trim((string) post('_loyalty_action'));

        switch ($action) {
            case 'schedule_review_14':
                return $this->scheduleReview($recordId, 14, 'Next review scheduled for 14 days from now.');

            case 'schedule_review_30':
                return $this->scheduleReview($recordId, 30, 'Next review scheduled for 30 days from now.');

            case 'mark_referral_ready':
                return $this->markReferralReady($recordId);

            case 'promote_return_value':
                return $this->promoteReturnValue($recordId);

            case 'mark_dormant':
                return $this->markDormant($recordId);

            case 'reactivate_record':
                return $this->reactivateRecord($recordId);

            case 'prepare_review_packet':
                return $this->prepareReviewPacket($recordId);

            case 'prepare_reactivation_packet':
                return $this->prepareReactivationPacket($recordId);

            case 'prepare_referral_packet':
                return $this->prepareReferralPacket($recordId);

            case 'prepare_return_value_packet':
                return $this->prepareReturnValuePacket($recordId);

            default:
                Flash::warning('Unknown loyalty continuity action.');
                return redirect(\Backend::url('cabnet/mykonosinquiry/loyaltyrecords/update/' . $recordId));
        }
    }

    protected function scheduleReview($recordId, int $days, string $successMessage)
    {
        return $this->runContinuityAction(
            $recordId,
            function (LoyaltyRecord $record) use ($days): bool {
                $target = Carbon::now()->addDays($days);
                $changed = !$record->next_review_at || $record->next_review_at->format('Y-m-d H:i:s') !== $target->format('Y-m-d H:i:s');

                if ($changed) {
                    $record->next_review_at = $target;
                }

                if (empty($record->owner_name)) {
                    $record->owner_name = $this->getOperatorName();
                    $changed = true;
                }

                return $changed;
            },
            $successMessage,
            sprintf('Continuity action: next review scheduled for %d days from now.', $days),
            [
                'touchpoint_outcome' => 'next_review_scheduled',
                'touchpoint_channel' => 'system',
                'is_internal' => true,
            ]
        );
    }

    protected function markReferralReady($recordId)
    {
        return $this->runContinuityAction(
            $recordId,
            function (LoyaltyRecord $record): bool {
                $changed = false;

                if ($record->continuity_status !== 'referral_ready') {
                    $record->continuity_status = 'referral_ready';
                    $changed = true;
                }

                if (!$record->referral_ready) {
                    $record->referral_ready = true;
                    $changed = true;
                }

                if ($record->loyalty_stage === 'review' || $record->loyalty_stage === 'watch' || $record->loyalty_stage === null || $record->loyalty_stage === '') {
                    $record->loyalty_stage = 'warm';
                    $changed = true;
                }

                if (empty($record->owner_name)) {
                    $record->owner_name = $this->getOperatorName();
                    $changed = true;
                }

                return $changed;
            },
            'Record marked as referral-ready.',
            'Continuity action: record flagged as referral-ready.',
            [
                'touchpoint_outcome' => 'referral_ready',
                'touchpoint_channel' => 'system',
                'is_internal' => true,
            ]
        );
    }

    protected function promoteReturnValue($recordId)
    {
        return $this->runContinuityAction(
            $recordId,
            function (LoyaltyRecord $record): bool {
                $changed = false;
                $nextTier = $this->advanceReturnValueTier((string) $record->return_value_tier);

                if ($record->return_value_tier !== $nextTier) {
                    $record->return_value_tier = $nextTier;
                    $changed = true;
                }

                if (!$record->return_value_candidate) {
                    $record->return_value_candidate = true;
                    $changed = true;
                }

                if ($record->continuity_status !== 'referral_ready' && $record->continuity_status !== 'return_value_watch') {
                    $record->continuity_status = 'return_value_watch';
                    $changed = true;
                }

                if (($record->loyalty_stage === null || $record->loyalty_stage === '' || $record->loyalty_stage === 'review') && $record->continuity_status !== 'referral_ready') {
                    $record->loyalty_stage = 'watch';
                    $changed = true;
                }

                if (empty($record->owner_name)) {
                    $record->owner_name = $this->getOperatorName();
                    $changed = true;
                }

                return $changed;
            },
            'Return-value posture promoted.',
            'Continuity action: elevated return-value posture.',
            [
                'touchpoint_outcome' => 'return_value_promoted',
                'touchpoint_channel' => 'system',
                'is_internal' => true,
            ]
        );
    }

    protected function markDormant($recordId)
    {
        return $this->runContinuityAction(
            $recordId,
            function (LoyaltyRecord $record): bool {
                $changed = false;

                if ($record->continuity_status !== 'dormant') {
                    $record->continuity_status = 'dormant';
                    $changed = true;
                }

                if ($record->loyalty_stage === 'warm' || $record->loyalty_stage === 'retained' || $record->loyalty_stage === 're-engaged') {
                    $record->loyalty_stage = 'watch';
                    $changed = true;
                }

                return $changed;
            },
            'Record marked as dormant.',
            'Continuity action: record moved to dormant posture.',
            [
                'touchpoint_outcome' => 'dormant',
                'touchpoint_channel' => 'system',
                'is_internal' => true,
            ]
        );
    }

    protected function reactivateRecord($recordId)
    {
        return $this->runContinuityAction(
            $recordId,
            function (LoyaltyRecord $record): bool {
                $changed = false;

                if ($record->continuity_status !== 'active_retention') {
                    $record->continuity_status = 'active_retention';
                    $changed = true;
                }

                if ($record->loyalty_stage === null || $record->loyalty_stage === '' || $record->loyalty_stage === 'watch' || $record->loyalty_stage === 'review') {
                    $record->loyalty_stage = 'warm';
                    $changed = true;
                }

                $target = Carbon::now()->addDays(14);
                if (!$record->next_review_at || $record->next_review_at->lt(Carbon::now())) {
                    $record->next_review_at = $target;
                    $changed = true;
                }

                return $changed;
            },
            'Record reactivated for active retention.',
            'Continuity action: record reactivated for active retention.',
            [
                'touchpoint_outcome' => 'reactivated',
                'touchpoint_channel' => 'system',
                'is_internal' => true,
            ]
        );
    }


    protected function prepareReviewPacket($recordId)
    {
        return $this->preparePacketAction($recordId, 'review', 'Review packet prepared.');
    }

    protected function prepareReactivationPacket($recordId)
    {
        return $this->preparePacketAction($recordId, 'reactivation', 'Reactivation brief prepared.');
    }

    protected function prepareReferralPacket($recordId)
    {
        return $this->preparePacketAction($recordId, 'referral', 'Referral-safe brief prepared.');
    }

    protected function prepareReturnValuePacket($recordId)
    {
        return $this->preparePacketAction($recordId, 'return_value', 'Return-value stewardship brief prepared.');
    }

    protected function preparePacketAction($recordId, string $mode, string $successMessage)
    {
        $record = LoyaltyRecord::findOrFail($recordId);
        $changed = false;
        $operatorName = $this->getOperatorName();

        if (empty($record->owner_name)) {
            $record->owner_name = $operatorName;
            $changed = true;
        }

        if (($mode === 'review' || $mode === 'reactivation') && !$record->next_review_at) {
            $record->next_review_at = Carbon::now()->addDays($mode === 'reactivation' ? 7 : 14);
            $changed = true;
        }

        if ($changed) {
            $record->save();
        }

        $briefTitle = $this->resolvePacketTitle($record, $mode);
        $briefBody = $this->resolvePacketBrief($record, $mode);

        $record->appendTouchpoint(
            'system',
            $briefTitle . PHP_EOL . $briefBody,
            $operatorName,
            [
                'touchpoint_channel' => 'system',
                'touchpoint_outcome' => 'packet_prepared',
                'touchpoint_at' => Carbon::now(),
                'reference_code' => $record->request_reference,
                'is_internal' => true,
                'payload_json' => [
                    'entry_mode' => 'continuity_packet_actions',
                    'captured_from' => 'loyalty_record_update',
                    'packet_mode' => $mode,
                    'packet_title' => $briefTitle,
                    'packet_brief' => $briefBody,
                    'continuity_status_snapshot' => $record->continuity_status,
                    'loyalty_stage_snapshot' => $record->loyalty_stage,
                    'return_value_tier_snapshot' => $record->return_value_tier,
                    'referral_ready_snapshot' => (bool) $record->referral_ready,
                ],
            ]
        );

        Flash::success($successMessage);

        return redirect(\Backend::url('cabnet/mykonosinquiry/loyaltyrecords/update/' . $record->id));
    }

    protected function resolvePacketTitle(LoyaltyRecord $record, string $mode): string
    {
        switch ($mode) {
            case 'reactivation':
                return 'Prepared reactivation brief for ' . ($record->request_reference ?: $record->guest_name ?: 'loyalty record') . '.';

            case 'referral':
                return 'Prepared referral-safe brief for ' . ($record->request_reference ?: $record->guest_name ?: 'loyalty record') . '.';

            case 'return_value':
                return 'Prepared return-value stewardship brief for ' . ($record->request_reference ?: $record->guest_name ?: 'loyalty record') . '.';

            case 'review':
            default:
                return 'Prepared review packet for ' . ($record->request_reference ?: $record->guest_name ?: 'loyalty record') . '.';
        }
    }

    protected function resolvePacketBrief(LoyaltyRecord $record, string $mode): string
    {
        switch ($mode) {
            case 'reactivation':
                return $record->reactivation_packet_brief;

            case 'referral':
                return $record->referral_safe_packet_brief;

            case 'return_value':
                return $record->return_value_packet_brief;

            case 'review':
            default:
                return $record->review_packet_brief;
        }
    }

    protected function runContinuityAction($recordId, callable $mutator, string $successMessage, string $touchpointBody, array $meta = [])
    {
        $record = LoyaltyRecord::findOrFail($recordId);
        $changed = (bool) $mutator($record);

        if ($changed) {
            $record->save();
            $record->appendTouchpoint('system', $touchpointBody, $this->getOperatorName(), array_merge([
                'touchpoint_channel' => 'system',
                'touchpoint_outcome' => 'state_changed',
                'touchpoint_at' => Carbon::now(),
                'reference_code' => $record->request_reference,
                'is_internal' => true,
                'payload_json' => [
                    'entry_mode' => 'continuity_command_deck',
                    'captured_from' => 'loyalty_record_update',
                    'continuity_status_snapshot' => $record->continuity_status,
                    'loyalty_stage_snapshot' => $record->loyalty_stage,
                    'return_value_tier_snapshot' => $record->return_value_tier,
                    'referral_ready_snapshot' => (bool) $record->referral_ready,
                ],
            ], $meta));
            Flash::success($successMessage);
        } else {
            Flash::info('No continuity change was needed.');
        }

        return redirect(\Backend::url('cabnet/mykonosinquiry/loyaltyrecords/update/' . $record->id));
    }

    protected function captureTouchpointEntryFromPost(): array
    {
        $body = trim((string) post('new_touchpoint_body', post('new_touchpoint_note', '')));
        $touchpointType = trim((string) post('new_touchpoint_type', ''));
        $touchpointChannel = trim((string) post('new_touchpoint_channel', ''));
        $touchpointOutcome = trim((string) post('new_touchpoint_outcome', ''));
        $touchpointAt = $this->parsePostedDate('new_touchpoint_at');
        $nextStepAt = $this->parsePostedDate('new_touchpoint_next_step_at');
        $isInternal = post('new_touchpoint_is_internal', '1') ? true : false;

        $hasSignal = $body !== '' || $touchpointType !== '' || $touchpointChannel !== '' || $touchpointOutcome !== '' || $touchpointAt !== null || $nextStepAt !== null;

        if (!$hasSignal) {
            return [];
        }

        if ($touchpointType === '') {
            $touchpointType = $isInternal ? 'internal' : 'follow_up';
        }

        if ($touchpointOutcome === '') {
            $touchpointOutcome = $body !== '' ? 'note_added' : 'follow_up_logged';
        }

        if ($body === '') {
            $fragments = [];

            if ($touchpointOutcome !== '') {
                $fragments[] = 'Outcome: ' . $this->humanizeValue($touchpointOutcome);
            }

            if ($touchpointChannel !== '') {
                $fragments[] = 'Channel: ' . $this->humanizeValue($touchpointChannel);
            }

            $body = !empty($fragments) ? implode(' · ', $fragments) : 'Structured touchpoint logged.';
        }

        return [
            'touchpoint_type' => $touchpointType,
            'touchpoint_channel' => $touchpointChannel !== '' ? $touchpointChannel : null,
            'touchpoint_outcome' => $touchpointOutcome !== '' ? $touchpointOutcome : null,
            'touchpoint_at' => $touchpointAt ?: Carbon::now(),
            'next_step_at' => $nextStepAt,
            'is_internal' => $isInternal,
            'body' => $body,
            'author_name' => $this->getOperatorName(),
        ];
    }

    protected function parsePostedDate(string $key): ?Carbon
    {
        $value = trim((string) post($key, ''));

        if ($value === '') {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function advanceReturnValueTier(string $current): string
    {
        $tiers = ['watch', 'promising', 'strong', 'flagship'];
        $current = $current !== '' ? $current : 'watch';
        $index = array_search($current, $tiers, true);

        if ($index === false) {
            return 'promising';
        }

        return $tiers[min($index + 1, count($tiers) - 1)];
    }

    protected function humanizeValue(string $value): string
    {
        return ucwords(str_replace(['_', '-'], ' ', trim($value)));
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
