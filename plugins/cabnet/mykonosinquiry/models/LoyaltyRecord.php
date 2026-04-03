<?php namespace Cabnet\MykonosInquiry\Models;

use Carbon\Carbon;
use Model;
use Schema;

class LoyaltyRecord extends Model
{
    public const RECORD_TABLE = 'cabnet_mykonos_loyalty_records';
    public const TOUCHPOINT_TABLE = 'cabnet_mykonos_loyalty_touchpoints';

    public $table = self::RECORD_TABLE;

    protected $guarded = ['id'];

    protected $dates = [
        'next_review_at',
        'last_retention_contact_at',
        'last_visit_at',
        'created_at',
        'updated_at',
    ];

    public $jsonable = ['tags_json', 'payload_json'];

    public $hasMany = [
        'touchpoints' => [LoyaltyTouchpoint::class, 'order' => 'created_at desc'],
    ];

    public $belongsTo = [
        'source_inquiry' => [Inquiry::class, 'key' => 'source_inquiry_id'],
    ];

    protected $latestTouchpointCache = false;
    protected $latestPreparedPacketTouchpointCache = false;
    protected $latestExecutionTouchpointCache = false;
    protected $latestClosurePacketTouchpointCache = false;
    protected $latestFinishLaneTouchpointCache = false;

    public static function getWorkspaceInstallState(): array
    {
        $recordTableReady = Schema::hasTable(self::RECORD_TABLE);
        $touchpointTableReady = Schema::hasTable(self::TOUCHPOINT_TABLE);

        $requiredRecordColumns = [
            'source_inquiry_id',
            'request_reference',
            'continuity_status',
            'loyalty_stage',
            'referral_ready',
            'return_value_tier',
            'next_review_at',
            'last_retention_contact_at',
            'guest_name',
            'guest_email',
            'guest_phone',
            'country',
            'owner_name',
            'created_by',
            'service_focus_summary',
            'source_summary',
            'continuity_summary',
            'retention_notes',
            'preferred_season',
            'revisit_window',
            'last_visit_at',
            'tags_json',
            'payload_json',
        ];

        $requiredTouchpointColumns = [
            'loyalty_record_id',
            'source_inquiry_id',
            'touchpoint_type',
            'touchpoint_channel',
            'touchpoint_outcome',
            'touchpoint_at',
            'next_step_at',
            'author_name',
            'operator_name',
            'reference_code',
            'body',
            'touchpoint_summary',
            'is_internal',
            'payload_json',
        ];

        $missingRecordColumns = [];
        $missingTouchpointColumns = [];

        if ($recordTableReady) {
            foreach ($requiredRecordColumns as $column) {
                if (!Schema::hasColumn(self::RECORD_TABLE, $column)) {
                    $missingRecordColumns[] = $column;
                }
            }
        } else {
            $missingRecordColumns = $requiredRecordColumns;
        }

        if ($touchpointTableReady) {
            foreach ($requiredTouchpointColumns as $column) {
                if (!Schema::hasColumn(self::TOUCHPOINT_TABLE, $column)) {
                    $missingTouchpointColumns[] = $column;
                }
            }
        } else {
            $missingTouchpointColumns = $requiredTouchpointColumns;
        }

        $recordSchemaReady = $recordTableReady && empty($missingRecordColumns);
        $touchpointSchemaReady = $touchpointTableReady && empty($missingTouchpointColumns);

        return [
            'record_table_ready'         => $recordTableReady,
            'touchpoint_table_ready'     => $touchpointTableReady,
            'record_schema_ready'        => $recordSchemaReady,
            'touchpoint_schema_ready'    => $touchpointSchemaReady,
            'workspace_storage_ready'    => $recordSchemaReady && $touchpointSchemaReady,
            'missing_record_columns'     => $missingRecordColumns,
            'missing_touchpoint_columns' => $missingTouchpointColumns,
        ];
    }

    public static function workspaceStorageReady(): bool
    {
        return (bool) static::getWorkspaceInstallState()['workspace_storage_ready'];
    }

    public static function touchpointStorageReady(): bool
    {
        return (bool) static::getWorkspaceInstallState()['touchpoint_schema_ready'];
    }

    public function getContinuityStatusOptions(): array
    {
        return [
            'draft'              => 'Draft / staged',
            'active_retention'   => 'Active retention',
            'referral_ready'     => 'Referral ready',
            'return_value_watch' => 'Return-value watch',
            'dormant'            => 'Dormant',
            'archived'           => 'Archived',
        ];
    }

    public function getLoyaltyStageOptions(): array
    {
        return [
            'review'     => 'Review',
            'watch'      => 'Watch',
            'warm'       => 'Warm',
            'retained'   => 'Retained',
            're-engaged' => 'Re-engaged',
            'completed'  => 'Completed',
        ];
    }

    public function getReturnValueTierOptions(): array
    {
        return [
            'watch'     => 'Watch',
            'promising' => 'Promising',
            'strong'    => 'Strong',
            'flagship'  => 'Flagship',
        ];
    }

    public function getTouchpointTypeOptions(): array
    {
        return [
            'follow_up' => 'Follow-up',
            'review'    => 'Review',
            'internal'  => 'Internal note',
            'service'   => 'Service aftercare',
            'referral'  => 'Referral check-in',
            'revisit'   => 'Revisit signal',
            'system'    => 'System / command deck',
        ];
    }

    public function getTouchpointChannelOptions(): array
    {
        return [
            'email'     => 'Email',
            'phone'     => 'Phone',
            'whatsapp'  => 'WhatsApp',
            'sms'       => 'SMS',
            'in_person' => 'In person',
            'system'    => 'System',
            'other'     => 'Other',
        ];
    }

    public function getTouchpointOutcomeOptions(): array
    {
        return [
            'note_added'            => 'Note added',
            'follow_up_logged'      => 'Follow-up logged',
            'response_received'     => 'Response received',
            'no_reply'              => 'No reply',
            'revisit_signal'        => 'Revisit signal',
            'referral_ready'        => 'Referral-ready signal',
            'return_value_promoted' => 'Return-value promoted',
            'retained'              => 'Retention strengthened',
            'dormant'               => 'Dormant',
            'reactivated'           => 'Reactivated',
            'next_review_scheduled' => 'Next review scheduled',
            'packet_prepared'       => 'Packet prepared',
            'packet_started'        => 'Packet follow-through started',
            'packet_deferred'       => 'Packet deferred',
            'packet_checkin'        => 'Packet check-in scheduled',
            'packet_completed'      => 'Packet follow-through completed',
            'closure_packet_prepared'=> 'Stewardship closure packet prepared',
            'finish_lane_parked'    => 'Finish lane parked',
            'finish_lane_reopened'  => 'Finish lane reopened',
            'state_changed'         => 'State changed',
            'record_created'        => 'Record created',
        ];
    }

    public function getContinuityStatusLabelAttribute(): string
    {
        $options = $this->getContinuityStatusOptions();

        return $options[$this->continuity_status] ?? $this->humanizeValue($this->continuity_status) ?? 'Unknown';
    }

    public function getLoyaltyStageLabelAttribute(): string
    {
        $options = $this->getLoyaltyStageOptions();

        return $options[$this->loyalty_stage] ?? $this->humanizeValue($this->loyalty_stage) ?? 'Review';
    }

    public function getReturnValueTierLabelAttribute(): string
    {
        $options = $this->getReturnValueTierOptions();

        return $options[$this->return_value_tier] ?? $this->humanizeValue($this->return_value_tier) ?? 'Watch';
    }

    public function getLatestTouchpointSummaryAttribute(): string
    {
        $touchpoint = $this->getLatestTouchpointRecord();

        if (!$touchpoint) {
            return 'No touchpoint logged yet.';
        }

        $stamp = $touchpoint->touchpoint_at instanceof \DateTimeInterface
            ? $touchpoint->touchpoint_at->format('Y-m-d H:i')
            : (optional($touchpoint->created_at)->format('Y-m-d H:i') ?: 'Pending');

        $parts = [$stamp];

        if ($touchpoint->touchpoint_outcome) {
            $parts[] = $this->humanizeValue($touchpoint->touchpoint_outcome);
        }

        if ($touchpoint->touchpoint_channel) {
            $parts[] = $this->humanizeValue($touchpoint->touchpoint_channel);
        }

        return implode(' · ', array_filter($parts));
    }

    public function getLatestTouchpointBodyPreviewAttribute(): string
    {
        $touchpoint = $this->getLatestTouchpointRecord();

        if (!$touchpoint) {
            return 'No touchpoint narrative has been captured yet.';
        }

        $body = trim((string) ($touchpoint->body ?: $touchpoint->touchpoint_summary ?: ''));

        return $body !== '' ? $body : 'No touchpoint narrative has been captured yet.';
    }

    public function getSourceInquiryDisplayAttribute(): string
    {
        if (!$this->source_inquiry) {
            return 'No source inquiry linked.';
        }

        $reference = trim((string) $this->source_inquiry->request_reference);
        $guest = trim((string) $this->source_inquiry->full_name);

        if ($reference !== '' && $guest !== '') {
            return $reference . ' · ' . $guest;
        }

        return $reference !== '' ? $reference : ($guest !== '' ? $guest : 'Linked inquiry');
    }

    public function getGuestSnapshotAttribute(): string
    {
        return $this->formatSummary([
            'Guest'          => $this->guest_name,
            'Email'          => $this->guest_email,
            'Phone'          => $this->guest_phone,
            'Country'        => $this->country,
            'Owner'          => $this->owner_name,
            'Referral ready' => $this->referral_ready ? 'Yes' : 'No',
        ], 'Guest continuity basics are still sparse.');
    }

    public function getHistoryPreviewAttribute(): string
    {
        $lines = [];

        foreach ($this->touchpoints as $touchpoint) {
            $stamp = $touchpoint->touchpoint_at instanceof \DateTimeInterface
                ? $touchpoint->touchpoint_at->format('Y-m-d H:i')
                : (optional($touchpoint->created_at)->format('Y-m-d H:i') ?: 'Pending');

            $type = ucfirst(trim((string) ($touchpoint->touchpoint_type ?: 'internal')));
            $author = trim((string) (($touchpoint->author_name ?: $touchpoint->operator_name) ?: 'System'));
            $body = trim((string) (($touchpoint->body ?: $touchpoint->touchpoint_summary) ?: ''));

            $lines[] = sprintf('[%s] %s / %s', $stamp, $type, $author);
            $lines[] = $body;
            $lines[] = '';
        }

        if (empty($lines)) {
            return 'No loyalty continuity touchpoints yet.';
        }

        return trim(implode(PHP_EOL, $lines));
    }

    public function getLatestTouchpointOutcomeLabelAttribute(): string
    {
        $touchpoint = $this->getLatestTouchpointRecord();

        if (!$touchpoint || !$touchpoint->touchpoint_outcome) {
            return 'No outcome recorded yet.';
        }

        $options = $this->getTouchpointOutcomeOptions();
        $outcome = (string) $touchpoint->touchpoint_outcome;

        return $options[$outcome] ?? ($this->humanizeValue($outcome) ?? 'No outcome recorded yet.');
    }

    public function getLatestTouchpointChannelLabelAttribute(): string
    {
        $touchpoint = $this->getLatestTouchpointRecord();

        if (!$touchpoint || !$touchpoint->touchpoint_channel) {
            return 'No channel recorded yet.';
        }

        $options = $this->getTouchpointChannelOptions();
        $channel = (string) $touchpoint->touchpoint_channel;

        return $options[$channel] ?? ($this->humanizeValue($channel) ?? 'No channel recorded yet.');
    }

    public function getNextReviewWindowLabelAttribute(): string
    {
        if (!$this->next_review_at) {
            return 'Unscheduled';
        }

        $now = Carbon::now();
        $reviewAt = $this->next_review_at instanceof \DateTimeInterface
            ? Carbon::instance($this->next_review_at)
            : Carbon::parse($this->next_review_at);

        if ($reviewAt->lt($now->copy()->startOfDay())) {
            return 'Overdue';
        }

        if ($reviewAt->isSameDay($now)) {
            return 'Due today';
        }

        if ($reviewAt->lte($now->copy()->addDays(3)->endOfDay())) {
            return 'Due soon';
        }

        if ($reviewAt->lte($now->copy()->addDays(14)->endOfDay())) {
            return 'Near-term';
        }

        return 'Future';
    }

    public function getDecisionFocusLabelAttribute(): string
    {
        if ($this->continuity_status === 'referral_ready' || $this->referral_ready) {
            return 'Referral cultivation';
        }

        if (in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)) {
            return 'Return-value stewardship';
        }

        if ($this->continuity_status === 'dormant') {
            return 'Reactivation decision';
        }

        if ($this->getNextReviewWindowLabelAttribute() === 'Overdue' || $this->getNextReviewWindowLabelAttribute() === 'Due today') {
            return 'Review now';
        }

        $touchpoint = $this->getLatestTouchpointRecord();
        if ($touchpoint && $touchpoint->touchpoint_outcome === 'no_reply') {
            return 'Re-engagement decision';
        }

        return 'Retention watch';
    }

    public function getOutcomeDigestAttribute(): string
    {
        $touchpoint = $this->getLatestTouchpointRecord();

        if (!$touchpoint) {
            return 'No touchpoint outcome has been captured yet.';
        }

        $author = trim((string) (($touchpoint->author_name ?: $touchpoint->operator_name) ?: 'System'));
        $body = trim((string) ($touchpoint->body ?: $touchpoint->touchpoint_summary ?: 'No narrative captured.'));

        return $this->formatSummary([
            'Latest outcome' => $this->getLatestTouchpointOutcomeLabelAttribute(),
            'Channel' => $this->getLatestTouchpointChannelLabelAttribute(),
            'Logged at' => $touchpoint->touchpoint_at,
            'Next step at' => $touchpoint->next_step_at,
            'Logged by' => $author,
            'Internal only' => $touchpoint->is_internal ? 'Yes' : 'No',
            'Narrative' => $body,
        ], 'No touchpoint outcome has been captured yet.');
    }

    public function getNextStepVisibilityAttribute(): string
    {
        $nextReview = $this->next_review_at
            ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')'
            : 'No next review is currently scheduled.';

        $lastTouch = $this->latest_touchpoint_summary ?: 'No touchpoint logged yet.';
        $owner = trim((string) $this->owner_name) !== '' ? trim((string) $this->owner_name) : 'Owner not assigned';

        return $this->formatSummary([
            'Decision focus' => $this->decision_focus_label,
            'Next review' => $nextReview,
            'Last touchpoint' => $lastTouch,
            'Owner' => $owner,
        ], 'Next-step visibility is still limited.');
    }

    public function getReferralReturnValueSummaryAttribute(): string
    {
        $recommendation = 'Keep under watch until stronger continuity signals appear.';

        if ($this->continuity_status === 'referral_ready' || $this->referral_ready) {
            $recommendation = 'Use referral-safe follow-up language and protect goodwill before asking for introductions.';
        } elseif (in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)) {
            $recommendation = 'Treat this guest as high return-value and preserve continuity ownership tightly.';
        } elseif ($this->continuity_status === 'dormant') {
            $recommendation = 'Frame the next move as a reactivation check rather than an active value ask.';
        }

        return $this->formatSummary([
            'Referral ready' => $this->referral_ready ? 'Yes' : 'No',
            'Continuity status' => $this->continuity_status_label,
            'Return-value tier' => $this->return_value_tier_label,
            'Decision focus' => $this->decision_focus_label,
            'Recommendation' => $recommendation,
        ], 'Referral and return-value posture is still minimal.');
    }

    public function getContinuityDecisionFrameAttribute(): string
    {
        $frame = [];
        $frame[] = 'Current posture: ' . $this->continuity_status_label . ' / ' . $this->loyalty_stage_label . '.';
        $frame[] = 'Primary focus: ' . $this->decision_focus_label . '.';

        if ($this->latest_touchpoint_summary && $this->latest_touchpoint_summary !== 'No touchpoint logged yet.') {
            $frame[] = 'Latest touchpoint: ' . $this->latest_touchpoint_summary . '.';
        }

        if ($this->next_review_at) {
            $frame[] = 'Next review window: ' . $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ').';
        } else {
            $frame[] = 'Next review window: unscheduled.';
        }

        if ($this->referral_ready) {
            $frame[] = 'Referral posture is active, so any outreach should protect relationship quality before requesting introductions.';
        } elseif (in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)) {
            $frame[] = 'Return-value posture is elevated, so continuity actions should favor stewardship over broad outreach.';
        } elseif ($this->continuity_status === 'dormant') {
            $frame[] = 'This record is dormant and should be treated as a reactivation decision rather than an active retention cycle.';
        } else {
            $frame[] = 'This record remains in a narrow loyalty watch posture and should not drift into campaign-style handling.';
        }

        return implode(PHP_EOL, $frame);
    }


    public function getContinuityEvidenceStrengthLabelAttribute(): string
    {
        $score = 0;

        foreach ([
            $this->guest_name,
            $this->service_focus_summary,
            $this->source_summary,
            $this->continuity_summary,
            $this->retention_notes,
        ] as $value) {
            if ($this->normalizeDisplayValue($value) !== null) {
                $score++;
            }
        }

        if ($this->getLatestTouchpointRecord()) {
            $score++;
        }

        if ($this->next_review_at) {
            $score++;
        }

        if ($this->last_retention_contact_at) {
            $score++;
        }

        if ($this->referral_ready || in_array((string) $this->return_value_tier, ['promising', 'strong', 'flagship'], true)) {
            $score++;
        }

        if ($score >= 8) {
            return 'Strong';
        }

        if ($score >= 6) {
            return 'Actionable';
        }

        if ($score >= 3) {
            return 'Emerging';
        }

        return 'Thin';
    }

    public function getRetentionRecommendationLabelAttribute(): string
    {
        $touchpoint = $this->getLatestTouchpointRecord();
        $reviewWindow = $this->getNextReviewWindowLabelAttribute();

        if ($this->continuity_status === 'referral_ready' || $this->referral_ready) {
            return 'Protect referral goodwill';
        }

        if ($this->continuity_status === 'dormant') {
            return 'Run reactivation check';
        }

        if (in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)) {
            return 'Steward high-value relationship';
        }

        if (in_array($reviewWindow, ['Overdue', 'Due today'], true)) {
            return 'Review and touch now';
        }

        if ($touchpoint && $touchpoint->touchpoint_outcome === 'no_reply') {
            return 'Re-engage carefully';
        }

        if ($touchpoint && in_array((string) $touchpoint->touchpoint_outcome, ['response_received', 'retained', 'revisit_signal'], true)) {
            return 'Keep warm continuity';
        }

        return 'Maintain retention watch';
    }

    public function getRetentionPacketSummaryAttribute(): string
    {
        $nextReview = $this->next_review_at
            ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')'
            : 'No review is scheduled yet.';

        $packetAnchor = trim((string) $this->request_reference) !== ''
            ? trim((string) $this->request_reference)
            : $this->source_inquiry_display;

        return $this->formatSummary([
            'Packet anchor' => $packetAnchor,
            'Evidence strength' => $this->continuity_evidence_strength_label,
            'Recommendation' => $this->retention_recommendation_label,
            'Decision focus' => $this->decision_focus_label,
            'Review window' => $this->next_review_window_label,
            'Next review' => $nextReview,
            'Latest outcome' => $this->latest_touchpoint_outcome_label,
            'Latest touchpoint' => $this->latest_touchpoint_summary,
            'Owner' => $this->owner_name ?: 'Owner not assigned',
        ], 'Retention packet summary is still limited.');
    }

    public function getEvidenceFrameSummaryAttribute(): string
    {
        return $this->formatSummary([
            'Source inquiry' => $this->source_inquiry_display,
            'Why loyalty now' => $this->firstMeaningfulLine($this->continuity_summary, 'Continuity reason is still minimal.'),
            'Service focus' => $this->firstMeaningfulLine($this->service_focus_summary, 'Service focus is still minimal.'),
            'Source frame' => $this->firstMeaningfulLine($this->source_summary, 'Source frame is still minimal.'),
            'Latest narrative' => $this->firstMeaningfulLine($this->latest_touchpoint_body_preview, 'No touchpoint narrative has been captured yet.'),
            'Retention note posture' => $this->firstMeaningfulLine($this->retention_notes, 'No retention notes have been written yet.'),
            'Last visit' => $this->last_visit_at ? $this->last_visit_at->format('Y-m-d') : 'No visit date captured',
            'Preferred season' => $this->preferred_season,
            'Revisit window' => $this->revisit_window,
        ], 'Evidence frame is still limited.');
    }


    public function getPacketActionRecommendationLabelAttribute(): string
    {
        if ($this->continuity_status === 'referral_ready' || $this->referral_ready) {
            return 'Prepare referral-safe brief';
        }

        if ($this->continuity_status === 'dormant') {
            return 'Prepare reactivation brief';
        }

        if (in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)) {
            return 'Prepare return-value brief';
        }

        if (in_array($this->getNextReviewWindowLabelAttribute(), ['Overdue', 'Due today', 'Due soon'], true)) {
            return 'Prepare review packet';
        }

        $touchpoint = $this->getLatestTouchpointRecord();
        if ($touchpoint && $touchpoint->touchpoint_outcome === 'no_reply') {
            return 'Prepare reactivation brief';
        }

        return 'Prepare review packet';
    }

    public function getOperatorActionBriefAttribute(): string
    {
        switch ($this->packet_action_recommendation_label) {
            case 'Prepare referral-safe brief':
                return $this->getReferralSafePacketBriefAttribute();

            case 'Prepare reactivation brief':
                return $this->getReactivationPacketBriefAttribute();

            case 'Prepare return-value brief':
                return $this->getReturnValuePacketBriefAttribute();

            case 'Prepare review packet':
            default:
                return $this->getReviewPacketBriefAttribute();
        }
    }

    public function getReviewPacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Review packet',
            'Review continuity posture, confirm the next review window, and keep the record in narrow stewardship handling.',
            [
                'Review window' => $this->next_review_window_label,
                'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') : 'Not scheduled',
            ]
        );
    }

    public function getReactivationPacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Reactivation brief',
            'Treat the next move as a careful reactivation check, not a live retention push.',
            [
                'Dormancy posture' => $this->continuity_status === 'dormant' ? 'Dormant / reactivation needed' : 'Reactivation brief prepared from current touchpoint signals',
                'Last touchpoint outcome' => $this->latest_touchpoint_outcome_label,
            ]
        );
    }

    public function getReferralSafePacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Referral-safe brief',
            'Protect goodwill first and frame any referral ask only after relationship quality is reconfirmed.',
            [
                'Referral posture' => $this->referral_ready ? 'Referral-ready flag active' : 'Referral-safe posture under review',
                'Return-value tier' => $this->return_value_tier_label,
            ]
        );
    }

    public function getReturnValuePacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Return-value stewardship brief',
            'Use a stewardship-style next move that protects relationship quality and long-cycle value.',
            [
                'Return-value tier' => $this->return_value_tier_label,
                'Continuity status' => $this->continuity_status_label,
            ]
        );
    }

    public function getLatestPreparedPacketLabelAttribute(): string
    {
        if (!$this->id || !static::touchpointStorageReady()) {
            return 'No packet prepared yet.';
        }

        $touchpoint = LoyaltyTouchpoint::where('loyalty_record_id', $this->id)
            ->where('touchpoint_outcome', 'packet_prepared')
            ->orderBy('touchpoint_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$touchpoint) {
            return 'No packet prepared yet.';
        }

        $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];
        $mode = trim((string) ($payload['packet_mode'] ?? ''));

        if ($mode !== '') {
            return ucwords(str_replace('_', ' ', $mode)) . ' packet prepared';
        }

        return 'Packet prepared';
    }

    public function getLatestPreparedPacketModeAttribute(): string
    {
        $touchpoint = $this->getLatestPreparedPacketTouchpoint();

        if (!$touchpoint) {
            return '';
        }

        $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

        return trim((string) ($payload['packet_mode'] ?? ''));
    }

    public function getPacketActionRecommendationModeAttribute(): string
    {
        switch ($this->packet_action_recommendation_label) {
            case 'Prepare referral-safe brief':
                return 'referral';

            case 'Prepare reactivation brief':
                return 'reactivation';

            case 'Prepare return-value brief':
                return 'return_value';

            case 'Prepare review packet':
            default:
                return 'review';
        }
    }

    public function getPacketExecutionStatusLabelAttribute(): string
    {
        $executionTouchpoint = $this->getLatestExecutionTouchpoint();

        if ($executionTouchpoint) {
            $payload = is_array($executionTouchpoint->payload_json) ? $executionTouchpoint->payload_json : [];
            $state = trim((string) ($payload['execution_state'] ?? ''));

            switch ($state) {
                case 'in_progress':
                    return 'Follow-through in progress';

                case 'deferred':
                    return 'Deferred for later review';

                case 'scheduled_checkin':
                    return 'Check-in scheduled';

                case 'completed':
                    return 'Follow-through completed';
            }
        }

        if ($this->latest_prepared_packet_mode !== '') {
            return 'Prepared / awaiting follow-through';
        }

        return 'No packet execution started';
    }

    public function getNextExecutionMoveLabelAttribute(): string
    {
        if ($this->latest_prepared_packet_mode === '') {
            return $this->packet_action_recommendation_label;
        }

        switch ($this->packet_execution_status_label) {
            case 'Prepared / awaiting follow-through':
                return 'Start packet follow-through';

            case 'Follow-through in progress':
                return 'Schedule a near check-in or complete the packet';

            case 'Deferred for later review':
                return 'Review deferred packet on the next review date';

            case 'Check-in scheduled':
                return 'Run the scheduled check-in and then complete or defer';

            case 'Follow-through completed':
                return 'Monitor outcome and prepare the next narrow packet only if needed';

            default:
                return 'Review packet posture';
        }
    }

    public function getLatestExecutionNotePreviewAttribute(): string
    {
        $touchpoint = $this->getLatestExecutionTouchpoint();

        if (!$touchpoint) {
            return 'No packet follow-through note has been captured yet.';
        }

        $body = trim((string) ($touchpoint->body ?: $touchpoint->touchpoint_summary ?: ''));

        return $body !== '' ? $body : 'No packet follow-through note has been captured yet.';
    }

    public function getPacketExecutionSummaryAttribute(): string
    {
        $latestPrepared = $this->latest_prepared_packet_label;
        $latestExecution = $this->getLatestExecutionTouchpoint();
        $payload = $latestExecution && is_array($latestExecution->payload_json) ? $latestExecution->payload_json : [];
        $packetMode = trim((string) ($payload['packet_mode'] ?? $this->latest_prepared_packet_mode));

        return $this->formatSummary([
            'Prepared packet' => $latestPrepared,
            'Packet mode' => $packetMode !== '' ? $this->humanizeValue($packetMode) : 'Not prepared yet',
            'Execution status' => $this->packet_execution_status_label,
            'Next execution move' => $this->next_execution_move_label,
            'Owner' => $this->owner_name ?: 'Owner not assigned',
            'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') : 'Not scheduled',
            'Latest execution note' => $this->firstMeaningfulLine($this->latest_execution_note_preview, 'No packet follow-through note has been captured yet.'),
        ], 'Packet execution framing is still sparse.');
    }

    public function getContinuityLoopPostureLabelAttribute(): string
    {
        $status = $this->packet_execution_status_label;
        $latestOutcome = trim((string) optional($this->getLatestTouchpointRecord())->touchpoint_outcome);

        if ($status === 'No packet execution started') {
            return $this->latest_prepared_packet_mode !== ''
                ? 'Prepared loop / awaiting start'
                : 'No loop started';
        }

        switch ($status) {
            case 'Prepared / awaiting follow-through':
                return 'Prepared loop / awaiting start';

            case 'Follow-through in progress':
                return 'Open loop / in progress';

            case 'Deferred for later review':
                return 'Deferred loop / review later';

            case 'Check-in scheduled':
                return 'Timed loop / check-in scheduled';

            case 'Follow-through completed':
                if (in_array($latestOutcome, ['response_received', 'retained', 'revisit_signal', 'referral_ready', 'return_value_promoted', 'reactivated'], true)) {
                    return 'Closed loop / positive signal';
                }

                if (in_array($latestOutcome, ['no_reply', 'dormant'], true)) {
                    return 'Closed loop / later re-entry';
                }

                return 'Closed loop / review posture';
        }

        return 'Loop posture unclear';
    }

    public function getExecutionTraceDigestAttribute(): string
    {
        $latestPrepared = $this->latest_prepared_packet_label;
        $latestExecution = $this->getLatestExecutionTouchpoint();
        $latestTouchpoint = $this->getLatestTouchpointRecord();
        $executionAt = $latestExecution
            ? ($latestExecution->touchpoint_at ?: $latestExecution->created_at)
            : null;

        return $this->formatSummary([
            'Loop posture' => $this->continuity_loop_posture_label,
            'Prepared packet' => $latestPrepared,
            'Execution status' => $this->packet_execution_status_label,
            'Latest outcome' => $this->latest_touchpoint_outcome_label,
            'Execution logged at' => $executionAt,
            'Latest execution note' => $this->firstMeaningfulLine($this->latest_execution_note_preview, 'No packet follow-through note has been captured yet.'),
            'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')' : 'Not scheduled',
            'Owner' => $this->owner_name ?: 'Owner not assigned',
        ], 'Execution trace readability is still limited.');
    }

    public function getRecentExecutionTraceAttribute(): string
    {
        $lines = [];
        $seen = [];

        $candidates = [
            'Prepared packet' => $this->getLatestPreparedPacketTouchpoint(),
            'Execution state' => $this->getLatestExecutionTouchpoint(),
            'Latest outcome' => $this->getLatestTouchpointRecord(),
        ];

        foreach ($candidates as $label => $touchpoint) {
            $line = $this->buildTraceLine($label, $touchpoint, $seen);

            if ($line !== null) {
                $lines[] = $line;
            }
        }

        return empty($lines)
            ? 'No continuity trace has been captured yet.'
            : implode(PHP_EOL, $lines);
    }


    public function getLatestClosurePacketLabelAttribute(): string
    {
        $touchpoint = $this->getLatestClosurePacketTouchpoint();

        if (!$touchpoint) {
            return 'No closure packet prepared yet.';
        }

        $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];
        $mode = trim((string) ($payload['closure_packet_mode'] ?? ''));

        if ($mode !== '') {
            return ucwords(str_replace('_', ' ', $mode)) . ' closure packet prepared';
        }

        return 'Closure packet prepared';
    }

    public function getClosurePacketRecommendationLabelAttribute(): string
    {
        $latestTouchpoint = $this->getLatestTouchpointRecord();
        $latestOutcome = $latestTouchpoint ? (string) $latestTouchpoint->touchpoint_outcome : '';
        $latestClosureMode = $this->latest_closure_packet_mode;
        $executionStatus = $this->packet_execution_status_label;

        if ($latestClosureMode === 'referral') {
            return 'Prepare referral closure packet';
        }

        if ($latestClosureMode === 'return_value') {
            return 'Prepare return-value closure packet';
        }

        if ($latestClosureMode === 'reactivation') {
            return 'Prepare reactivation closure packet';
        }

        if (in_array($executionStatus, ['No packet execution started', 'Prepared / awaiting follow-through', 'Follow-through in progress'], true)) {
            return 'Prepare review closure posture';
        }

        if ($this->continuity_status === 'referral_ready' || $this->referral_ready || in_array($latestOutcome, ['referral_ready'], true)) {
            return 'Prepare referral closure packet';
        }

        if (in_array((string) $this->return_value_tier, ['strong', 'flagship'], true) || in_array($latestOutcome, ['return_value_promoted'], true)) {
            return 'Prepare return-value closure packet';
        }

        if (in_array($latestOutcome, ['reactivated', 'response_received', 'retained', 'revisit_signal'], true) || $this->loyalty_stage === 're-engaged' || $this->continuity_status === 'dormant') {
            return 'Prepare reactivation closure packet';
        }

        if ($executionStatus === 'Follow-through completed') {
            return 'Prepare review closure posture';
        }

        return 'Prepare review closure posture';
    }

    public function getLatestClosurePacketModeAttribute(): string
    {
        $touchpoint = $this->getLatestClosurePacketTouchpoint();

        if (!$touchpoint) {
            return '';
        }

        $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

        return trim((string) ($payload['closure_packet_mode'] ?? ''));
    }


public function getLatestFinishLaneModeAttribute(): string
{
    $touchpoint = $this->getLatestFinishLaneTouchpoint();

    if (!$touchpoint) {
        return '';
    }

    $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

    return trim((string) ($payload['finish_lane_mode'] ?? ''));
}

public function getLatestFinishLaneStateAttribute(): string
{
    $touchpoint = $this->getLatestFinishLaneTouchpoint();

    if (!$touchpoint) {
        return '';
    }

    $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

    return trim((string) ($payload['finish_lane_state'] ?? ''));
}

public function getLatestFinishLaneLabelAttribute(): string
{
    $touchpoint = $this->getLatestFinishLaneTouchpoint();

    if (!$touchpoint) {
        return 'No finish lane parked yet.';
    }

    $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];
    $mode = trim((string) ($payload['finish_lane_mode'] ?? ''));
    $state = trim((string) ($payload['finish_lane_state'] ?? ''));
    $label = $mode !== '' ? ($this->humanizeValue($mode) ?: 'Finish') : 'Finish';

    if ($state === 'reopened') {
        return $label . ' lane reopened for operator review';
    }

    if ($state === 'parked') {
        return $label . ' lane parked';
    }

    return $label . ' lane updated';
}

public function getFinishLaneStatusLabelAttribute(): string
{
    $touchpoint = $this->getLatestFinishLaneTouchpoint();

    if ($touchpoint) {
        $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];
        $mode = trim((string) ($payload['finish_lane_mode'] ?? ''));
        $state = trim((string) ($payload['finish_lane_state'] ?? ''));

        if ($state === 'reopened') {
            return 'Finish lane reopened';
        }

        switch ($mode) {
            case 'referral':
                return 'Referral lane parked';
            case 'return_value':
                return 'Return-value lane parked';
            case 'reactivation':
                return 'Reactivation lane parked';
            default:
                return 'Finish lane parked';
        }
    }

    if ($this->latest_closure_packet_mode !== '') {
        return 'Closure packet prepared';
    }

    return 'No finish lane parked';
}

public function getParkedFinishWindowLabelAttribute(): string
{
    $mode = $this->latest_finish_lane_mode;

    if ($mode === '') {
        $mode = $this->latest_closure_packet_mode;
    }

    if ($mode === '') {
        switch ($this->closure_packet_recommendation_label) {
            case 'Prepare referral closure packet':
                $mode = 'referral';
                break;
            case 'Prepare return-value closure packet':
                $mode = 'return_value';
                break;
            case 'Prepare reactivation closure packet':
                $mode = 'reactivation';
                break;
            default:
                $mode = 'review';
                break;
        }
    }

    switch ($mode) {
        case 'referral':
            return '60-day parked goodwill window';
        case 'return_value':
            return '45-day parked value-watch window';
        case 'reactivation':
            return '21-day parked reactivation review';
        default:
            return '21-day parked review window';
    }
}

public function getParkedLaneWatchLabelAttribute(): string
{
    $mode = $this->latest_finish_lane_mode;
    $state = $this->latest_finish_lane_state;

    if ($state === 'reopened') {
        return 'Reopened for proof review';
    }

    if ($mode === '') {
        if ($this->latest_closure_packet_mode !== '') {
            return 'Awaiting deliberate lane parking';
        }

        return 'No parked watch active';
    }

    switch ($mode) {
        case 'referral':
            return $this->referral_ready ? 'Goodwill hold / referral-safe watch' : 'Goodwill preservation watch';
        case 'return_value':
            return in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)
                ? 'High-value stewardship watch'
                : 'Measured value-watch';
        case 'reactivation':
            return 'Short reactivation proof watch';
        default:
            return 'Review watch';
    }
}

public function getParkedLaneReopenTriggerLabelAttribute(): string
{
    $mode = $this->latest_finish_lane_mode;
    $state = $this->latest_finish_lane_state;

    if ($state === 'reopened') {
        return 'Operator is actively rebuilding the finish lane from fresh proof.';
    }

    if ($mode === '') {
        if ($this->latest_closure_packet_mode !== '') {
            return 'Park the matching finish lane deliberately before defining a reopen trigger.';
        }

        return 'No parked lane to reopen yet.';
    }

    switch ($mode) {
        case 'referral':
            return 'Reopen only on a new referral cue, direct ask, or ownership change.';
        case 'return_value':
            return 'Reopen only on a new value signal, premium intent, or deliberate owner review.';
        case 'reactivation':
            return 'Reopen only on a fresh contact signal, missed review, or reactivation proof.';
        default:
            return 'Reopen only on new proof.';
    }
}

public function getFinishLaneSnapshotSummaryAttribute(): string
{
    return $this->formatSummary([
        'Finish lane status' => $this->finish_lane_status_label,
        'Latest finish lane' => $this->latest_finish_lane_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Reopen trigger' => $this->parked_lane_reopen_trigger_label,
        'Parked finish window' => $this->parked_finish_window_label,
        'Finish posture' => $this->stewardship_finish_posture_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Latest closure packet' => $this->latest_closure_packet_label,
        'Next finish move' => $this->next_finish_move_label,
        'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') : 'Not scheduled',
    ], 'Finish lane follow-through is still minimal.');
}

public function getFinishLaneFollowThroughFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Finish lane status: ' . $this->finish_lane_status_label . '.';
    $lines[] = 'Latest finish lane: ' . $this->latest_finish_lane_label . '.';
    $lines[] = 'Parked watch: ' . $this->parked_lane_watch_label . '.';
    $lines[] = 'Reopen trigger: ' . rtrim($this->parked_lane_reopen_trigger_label, '.') . '.';
    $lines[] = 'Parked window: ' . $this->parked_finish_window_label . '.';
    $lines[] = 'Finish posture: ' . $this->stewardship_finish_posture_label . '.';
    $lines[] = 'Next finish move: ' . $this->next_finish_move_label . '.';

    if ($this->latest_finish_lane_mode !== '') {
        $lines[] = 'The record is already parked on an explicit finish lane and should only be reopened on new proof.';
    } elseif ($this->latest_closure_packet_mode !== '') {
        $lines[] = 'A closure packet exists, but the finish lane is not explicitly parked yet, so the next safe move is to park the matching lane deliberately.';
    } else {
        $lines[] = 'No closure packet is parked yet, so finish handling should stay narrow until the stewardship lane is explicit.';
    }

    return implode(PHP_EOL, $lines);
}

public function getParkedStateDigestAttribute(): string
{
    return $this->formatSummary([
        'Parked watch' => $this->parked_lane_watch_label,
        'Finish lane status' => $this->finish_lane_status_label,
        'Latest finish lane' => $this->latest_finish_lane_label,
        'Reopen trigger' => $this->parked_lane_reopen_trigger_label,
        'Parked finish window' => $this->parked_finish_window_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Latest outcome' => $this->latest_touchpoint_outcome_label,
        'Latest prepared packet' => $this->latest_prepared_packet_label,
        'Latest closure packet' => $this->latest_closure_packet_label,
        'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') : 'Not scheduled',
    ], 'Parked-state digest is still minimal.');
}

public function getParkedStateVisibilityFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Parked watch: ' . $this->parked_lane_watch_label . '.';
    $lines[] = 'Finish lane status: ' . $this->finish_lane_status_label . '.';
    $lines[] = 'Reopen trigger: ' . rtrim($this->parked_lane_reopen_trigger_label, '.') . '.';
    $lines[] = 'Parked window: ' . $this->parked_finish_window_label . '.';

    switch ($this->latest_finish_lane_mode) {
        case 'referral':
            $lines[] = 'Referral parking should stay low-pressure, goodwill-preserving, and human-owned.';
            break;
        case 'return_value':
            $lines[] = 'Return-value parking should stay measured, stewardship-led, and alert to premium intent rather than broad outreach.';
            break;
        case 'reactivation':
            $lines[] = 'Reactivation parking should stay short-window and proof-sensitive rather than broad or automated.';
            break;
        default:
            if ($this->latest_closure_packet_mode !== '') {
                $lines[] = 'A closure packet exists, but the finish lane still needs deliberate parking before the parked posture is fully readable.';
            } else {
                $lines[] = 'No parked finish lane exists yet, so finish handling should stay narrow until a human operator parks the record deliberately.';
            }
            break;
    }

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'The lane is reopened, so the parked posture is suspended until a fresh finish decision is made.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        $lines[] = 'The parked lane should remain stable until fresh proof justifies a deliberate reopen.';
    }

    return implode(PHP_EOL, $lines);
}

public function getParkedLaneOutcomeLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopened for deliberate finish review';
    }

    if ($this->latest_finish_lane_mode === '') {
        if ($this->latest_closure_packet_mode !== '') {
            return 'Closure packet ready for lane parking';
        }

        if ($this->closure_readiness_label === 'Ready for finish packet') {
            return 'Ready for closure decision';
        }

        return 'No parked outcome yet';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Parked lane due for human review';
    }

    switch ($this->latest_finish_lane_mode) {
        case 'referral':
            return 'Referral goodwill held in parked posture';
        case 'return_value':
            return 'Return-value stewardship held in parked posture';
        case 'reactivation':
            return 'Reactivation lane parked for proof watch';
        default:
            return 'Parked finish posture active';
    }
}

public function getParkedLaneOutcomeDigestAttribute(): string
{
    $nextReview = $this->next_review_at
        ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')'
        : 'Not scheduled';

    return $this->formatSummary([
        'Finish dashboard' => $this->finish_dashboard_status_label,
        'Parked lane outcome' => $this->parked_lane_outcome_label,
        'Finish posture' => $this->stewardship_finish_posture_label,
        'Finish lane status' => $this->finish_lane_status_label,
        'Latest finish lane' => $this->latest_finish_lane_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Next finish move' => $this->next_finish_move_label,
        'Latest outcome' => $this->latest_touchpoint_outcome_label,
        'Latest touchpoint' => $this->latest_touchpoint_summary,
        'Next review' => $nextReview,
    ], 'Parked-lane outcome readability is still minimal.');
}

public function getFinishDashboardStatusLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopened / awaiting fresh finish decision';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked / review window active';
        }

        return 'Parked / stewardship watch running';
    }

    if ($this->latest_closure_packet_mode !== '') {
        return 'Closure packet prepared / lane pending';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Ready / finish decision can be made';
        case 'Timed for later finish':
            return 'Timed / not yet ready to close';
        case 'Execution still open':
            return 'Execution open / do not finish yet';
        case 'Prepared but not yet executed':
            return 'Prepared / execution still pending';
        default:
            return 'Finish posture still emerging';
    }
}

public function getFinishDashboardSummaryAttribute(): string
{
    $nextReview = $this->next_review_at
        ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')'
        : 'Not scheduled';

    return $this->formatSummary([
        'Dashboard status' => $this->finish_dashboard_status_label,
        'Finish posture' => $this->stewardship_finish_posture_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Parked lane outcome' => $this->parked_lane_outcome_label,
        'Latest finish lane' => $this->latest_finish_lane_label,
        'Latest closure packet' => $this->latest_closure_packet_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Next finish move' => $this->next_finish_move_label,
        'Latest outcome' => $this->latest_touchpoint_outcome_label,
        'Next review' => $nextReview,
    ], 'Finish dashboard readability is still minimal.');
}

public function getStewardshipFinishDashboardFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Dashboard status: ' . $this->finish_dashboard_status_label . '.';
    $lines[] = 'Finish posture: ' . $this->stewardship_finish_posture_label . '.';
    $lines[] = 'Closure readiness: ' . $this->closure_readiness_label . '.';
    $lines[] = 'Parked lane outcome: ' . $this->parked_lane_outcome_label . '.';
    $lines[] = 'Next finish move: ' . $this->next_finish_move_label . '.';

    if ($this->latest_finish_lane_mode !== '') {
        $lines[] = 'Latest finish lane: ' . $this->latest_finish_lane_label . ' with a ' . $this->parked_finish_window_label . '.';
    } elseif ($this->latest_closure_packet_mode !== '') {
        $lines[] = 'Latest closure packet: ' . $this->latest_closure_packet_label . ' with a ' . $this->closure_window_label . '.';
    } else {
        $lines[] = 'No finish lane is explicit yet, so the record should stay narrow until a human operator closes or parks the lane deliberately.';
    }

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is reopened, the parked posture is suspended and the next human signal should rebuild the finish decision.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        $lines[] = 'Because the lane is parked, the record should remain quiet until the reopen trigger or review window justifies another deliberate move.';
    }

    return implode(PHP_EOL, $lines);
}

    public function getClosureReadinessLabelAttribute(): string
    {
        $finishLaneTouchpoint = $this->getLatestFinishLaneTouchpoint();

        if ($finishLaneTouchpoint) {
            $payload = is_array($finishLaneTouchpoint->payload_json) ? $finishLaneTouchpoint->payload_json : [];
            $state = trim((string) ($payload['finish_lane_state'] ?? ''));

            if ($state === 'reopened') {
                return 'Finish lane reopened';
            }

            return 'Finish lane parked';
        }

        if ($this->latest_closure_packet_mode !== '') {
            return 'Closure packet prepared';
        }

        switch ($this->packet_execution_status_label) {
            case 'Follow-through completed':
                return 'Ready for finish packet';

            case 'Check-in scheduled':
            case 'Deferred for later review':
                return 'Timed for later finish';

            case 'Follow-through in progress':
                return 'Execution still open';

            case 'Prepared / awaiting follow-through':
                return 'Prepared but not yet executed';

            default:
                return 'Finish posture still emerging';
        }
    }

    public function getNextFinishMoveLabelAttribute(): string
    {
        $finishLaneTouchpoint = $this->getLatestFinishLaneTouchpoint();

        if ($finishLaneTouchpoint) {
            $payload = is_array($finishLaneTouchpoint->payload_json) ? $finishLaneTouchpoint->payload_json : [];
            $state = trim((string) ($payload['finish_lane_state'] ?? ''));

            if ($state === 'reopened') {
                return 'Rebuild the finish lane from the next explicit signal';
            }

            return 'Hold the parked window and only reopen on new proof';
        }

        if ($this->latest_closure_packet_mode !== '') {
            return 'Park the matching finish lane and keep the record narrow';
        }

        switch ($this->closure_packet_recommendation_label) {
            case 'Prepare referral closure packet':
                return 'Prepare referral closure when goodwill is confirmed';

            case 'Prepare return-value closure packet':
                return 'Prepare return-value closure and park the value lane';

            case 'Prepare reactivation closure packet':
                return 'Prepare reactivation closure and return to review';

            case 'Prepare review closure posture':
            default:
                if ($this->packet_execution_status_label === 'Follow-through completed') {
                    return 'Hold a review closure posture until the next clear signal';
                }

                if (in_array($this->packet_execution_status_label, ['No packet execution started', 'Prepared / awaiting follow-through', 'Follow-through in progress'], true)) {
                    return 'Complete the current packet before choosing a finish lane';
                }

                return 'Keep the record in a narrow timed review posture';
        }
    }

    public function getFinishRecommendationReasonSummaryAttribute(): string
    {
        $latestOutcome = $this->latest_touchpoint_outcome_label;
        $latestTouchpoint = $this->getLatestTouchpointRecord();
        $latestNarrative = $this->firstMeaningfulLine($this->latest_touchpoint_body_preview, 'No touchpoint narrative has been captured yet.');

        return $this->formatSummary([
            'Closure readiness' => $this->closure_readiness_label,
            'Finish recommendation' => $this->closure_packet_recommendation_label,
            'Reason' => $this->buildFinishReasonLine(),
            'Execution status' => $this->packet_execution_status_label,
            'Latest outcome' => $latestOutcome,
            'Latest narrative' => $latestNarrative,
            'Loop posture' => $this->continuity_loop_posture_label,
            'Next move' => $this->next_finish_move_label,
        ], 'Finish recommendation reasoning is still minimal.');
    }

    public function getClosureEvidenceDigestAttribute(): string
    {
        $closureTouchpoint = $this->getLatestClosurePacketTouchpoint();
        $closureAt = $closureTouchpoint ? ($closureTouchpoint->touchpoint_at ?: $closureTouchpoint->created_at) : null;

        return $this->formatSummary([
            'Finish posture' => $this->stewardship_finish_posture_label,
            'Finish lane status' => $this->finish_lane_status_label,
            'Latest finish lane' => $this->latest_finish_lane_label,
            'Parked watch' => $this->parked_lane_watch_label,
            'Reopen trigger' => $this->parked_lane_reopen_trigger_label,
            'Parked finish window' => $this->parked_finish_window_label,
            'Closure recommendation' => $this->closure_packet_recommendation_label,
            'Latest closure packet' => $this->latest_closure_packet_label,
            'Closure packet logged at' => $closureAt,
            'Closure window' => $this->closure_window_label,
            'Evidence strength' => $this->continuity_evidence_strength_label,
            'Latest prepared packet' => $this->latest_prepared_packet_label,
            'Execution trace' => $this->firstMeaningfulLine($this->execution_trace_digest, 'Execution trace readability is still limited.'),
        ], 'Closure evidence digest is still minimal.');
    }

    public function getOutcomeDrivenFinishFrameAttribute(): string
    {
        $lines = [];
        $lines[] = 'Finish posture: ' . $this->stewardship_finish_posture_label . '.';
        $lines[] = 'Finish lane status: ' . $this->finish_lane_status_label . '.';
        $lines[] = 'Closure readiness: ' . $this->closure_readiness_label . '.';
        $lines[] = 'Recommendation: ' . $this->closure_packet_recommendation_label . '.';
        $lines[] = 'Why: ' . $this->buildFinishReasonLine() . '.';
        $lines[] = 'Next finish move: ' . $this->next_finish_move_label . '.';

        if ($this->latest_finish_lane_mode !== '') {
            $lines[] = 'Latest finish lane: ' . $this->latest_finish_lane_label . ' with a ' . $this->parked_finish_window_label . '.';
        } elseif ($this->latest_closure_packet_mode !== '') {
            $lines[] = 'Latest closure packet: ' . $this->latest_closure_packet_label . ' with a ' . $this->closure_window_label . '.';
        } else {
            $lines[] = 'No closure packet is prepared yet, so the record should stay narrow and readable until the finish lane is explicit.';
        }

        return implode(PHP_EOL, $lines);
    }

    public function getStewardshipFinishPostureLabelAttribute(): string
    {
        $mode = $this->latest_closure_packet_mode;

        if ($mode === 'referral' || $this->continuity_status === 'referral_ready' || $this->referral_ready) {
            return 'Referral goodwill preserved';
        }

        if ($mode === 'return_value' || in_array((string) $this->return_value_tier, ['strong', 'flagship'], true)) {
            return 'Return-value stewardship parked';
        }

        if ($mode === 'reactivation' || $this->loyalty_stage === 're-engaged') {
            return 'Reactivated and parked to review';
        }

        if ($this->continuity_status === 'dormant') {
            return 'Dormant until reactivation proof';
        }

        return 'Review posture maintained';
    }

    public function getClosureWindowLabelAttribute(): string
    {
        $mode = $this->latest_closure_packet_mode;

        if ($mode === '') {
            switch ($this->closure_packet_recommendation_label) {
                case 'Prepare referral closure packet':
                    $mode = 'referral';
                    break;
                case 'Prepare return-value closure packet':
                    $mode = 'return_value';
                    break;
                case 'Prepare reactivation closure packet':
                    $mode = 'reactivation';
                    break;
                default:
                    $mode = 'review';
                    break;
            }
        }

        switch ($mode) {
            case 'referral':
                return '45-day goodwill window';
            case 'return_value':
                return '30-day stewardship window';
            case 'reactivation':
                return '14-day reactivation window';
            default:
                return '21-day review window';
        }
    }

    public function getStewardshipSnapshotSummaryAttribute(): string
    {
        return $this->formatSummary([
            'Finish posture' => $this->stewardship_finish_posture_label,
            'Finish lane status' => $this->finish_lane_status_label,
            'Latest finish lane' => $this->latest_finish_lane_label,
            'Parked watch' => $this->parked_lane_watch_label,
            'Reopen trigger' => $this->parked_lane_reopen_trigger_label,
            'Parked finish window' => $this->parked_finish_window_label,
            'Closure recommendation' => $this->closure_packet_recommendation_label,
            'Latest closure packet' => $this->latest_closure_packet_label,
            'Closure window' => $this->closure_window_label,
            'Loop posture' => $this->continuity_loop_posture_label,
            'Execution status' => $this->packet_execution_status_label,
            'Latest outcome' => $this->latest_touchpoint_outcome_label,
            'Latest prepared' => $this->latest_prepared_packet_label,
            'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') : 'Not scheduled',
        ], 'Stewardship closure snapshot is still minimal.');
    }

    public function getReactivationClosurePacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Reactivation closure packet',
            'Close the current loop as re-engaged, park the record back into a narrow review window, and avoid widening into broad messaging.',
            [
                'Finish posture' => $this->stewardship_finish_posture_label,
                'Closure window' => '14-day reactivation window',
                'Latest execution' => $this->packet_execution_status_label,
                'Loop posture' => $this->continuity_loop_posture_label,
            ]
        );
    }

    public function getReferralClosurePacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Referral closure packet',
            'Close the loop by protecting goodwill first, then park the record on a longer referral-safe review window.',
            [
                'Finish posture' => $this->stewardship_finish_posture_label,
                'Closure window' => '45-day goodwill window',
                'Referral posture' => $this->referral_ready ? 'Referral-ready flag active' : 'Referral posture under operator review',
                'Loop posture' => $this->continuity_loop_posture_label,
            ]
        );
    }

    public function getReturnValueClosurePacketBriefAttribute(): string
    {
        return $this->buildPacketBrief(
            'Return-value closure packet',
            'Close the current loop as deliberate stewardship, then park the record on a measured value-watch window instead of broad re-engagement.',
            [
                'Finish posture' => $this->stewardship_finish_posture_label,
                'Closure window' => '30-day stewardship window',
                'Return-value tier' => $this->return_value_tier_label,
                'Loop posture' => $this->continuity_loop_posture_label,
            ]
        );
    }

    protected function getLatestPreparedPacketTouchpoint(): ?LoyaltyTouchpoint
    {
        if ($this->latestPreparedPacketTouchpointCache !== false) {
            return $this->latestPreparedPacketTouchpointCache ?: null;
        }

        $this->latestPreparedPacketTouchpointCache = $this->findLatestTouchpointByCallback(function (LoyaltyTouchpoint $touchpoint): bool {
            $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

            return $touchpoint->touchpoint_outcome === 'packet_prepared' || !empty($payload['packet_mode']);
        });

        return $this->latestPreparedPacketTouchpointCache ?: null;
    }

    protected function getLatestExecutionTouchpoint(): ?LoyaltyTouchpoint
    {
        if ($this->latestExecutionTouchpointCache !== false) {
            return $this->latestExecutionTouchpointCache ?: null;
        }

        $this->latestExecutionTouchpointCache = $this->findLatestTouchpointByCallback(function (LoyaltyTouchpoint $touchpoint): bool {
            $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

            return !empty($payload['execution_state']) || (($payload['entry_mode'] ?? null) === 'packet_execution_workbench');
        });

        return $this->latestExecutionTouchpointCache ?: null;
    }


    protected function getLatestClosurePacketTouchpoint(): ?LoyaltyTouchpoint
    {
        if ($this->latestClosurePacketTouchpointCache !== false) {
            return $this->latestClosurePacketTouchpointCache ?: null;
        }

        $this->latestClosurePacketTouchpointCache = $this->findLatestTouchpointByCallback(function (LoyaltyTouchpoint $touchpoint): bool {
            $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

            return $touchpoint->touchpoint_outcome === 'closure_packet_prepared' || !empty($payload['closure_packet_mode']);
        });

        return $this->latestClosurePacketTouchpointCache ?: null;
    }



protected function getLatestFinishLaneTouchpoint(): ?LoyaltyTouchpoint
{
    if ($this->latestFinishLaneTouchpointCache !== false) {
        return $this->latestFinishLaneTouchpointCache ?: null;
    }

    $this->latestFinishLaneTouchpointCache = $this->findLatestTouchpointByCallback(function (LoyaltyTouchpoint $touchpoint): bool {
        $payload = is_array($touchpoint->payload_json) ? $touchpoint->payload_json : [];

        return !empty($payload['finish_lane_mode']) || (($payload['entry_mode'] ?? null) === 'finish_lane_follow_through');
    });

    return $this->latestFinishLaneTouchpointCache ?: null;
}


    protected function findLatestTouchpointByCallback(callable $callback): ?LoyaltyTouchpoint
    {
        if (!$this->id || !static::touchpointStorageReady()) {
            return null;
        }

        $touchpoints = LoyaltyTouchpoint::where('loyalty_record_id', $this->id)
            ->orderBy('touchpoint_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($touchpoints as $touchpoint) {
            if ($callback($touchpoint)) {
                return $touchpoint;
            }
        }

        return null;
    }

    protected function buildPacketBrief(string $packetType, string $recommendedMove, array $extras = []): string
    {
        $pairs = array_merge([
            'Packet type' => $packetType,
            'Anchor' => $this->request_reference ?: $this->source_inquiry_display,
            'Guest' => $this->guest_name ?: 'Guest not captured',
            'Owner' => $this->owner_name ?: 'Owner not assigned',
            'Decision focus' => $this->decision_focus_label,
            'Recommendation' => $this->retention_recommendation_label,
            'Latest touchpoint' => $this->latest_touchpoint_summary,
            'Latest narrative' => $this->firstMeaningfulLine($this->latest_touchpoint_body_preview, 'No touchpoint narrative has been captured yet.'),
            'Evidence strength' => $this->continuity_evidence_strength_label,
            'Recommended move' => $recommendedMove,
        ], $extras);

        return $this->formatSummary($pairs, $packetType . ' is still sparse.');
    }

    public function getLatestTouchpointRecord(): ?LoyaltyTouchpoint
    {
        if ($this->latestTouchpointCache !== false) {
            return $this->latestTouchpointCache ?: null;
        }

        if (!$this->id || !static::touchpointStorageReady()) {
            $this->latestTouchpointCache = null;
            return null;
        }

        $this->latestTouchpointCache = LoyaltyTouchpoint::where('loyalty_record_id', $this->id)
            ->orderBy('touchpoint_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        return $this->latestTouchpointCache ?: null;
    }

    public static function syncFromInquiry(Inquiry $inquiry, array $overrides = [], ?string $operatorName = null): ?self
    {
        if (!$inquiry || !$inquiry->id || !static::workspaceStorageReady()) {
            return null;
        }

        $record = static::firstOrNew([
            'source_inquiry_id' => $inquiry->id,
        ]);

        $sourceSummary = trim(implode(PHP_EOL, array_filter([
            static::normalizeLine('Source title', $inquiry->source_title),
            static::normalizeLine('Source type', static::humanizeStatic($inquiry->source_type)),
            static::normalizeLine('Source URL', $inquiry->source_url),
            static::normalizeLine('Requested mode', static::humanizeStatic($inquiry->requested_mode)),
        ])));

        $continuitySummary = trim(implode(PHP_EOL, array_filter([
            static::normalizeLine('Inquiry status', static::humanizeStatic($inquiry->status)),
            static::normalizeLine('Priority', static::humanizeStatic($inquiry->priority)),
            static::normalizeLine('Owner', $inquiry->owner_name),
            static::normalizeLine('Last contacted', static::formatDateStatic($inquiry->last_contacted_at, 'Y-m-d H:i')),
            static::normalizeLine('Follow-up', static::formatDateStatic($inquiry->follow_up_date, 'Y-m-d')),
            static::normalizeLine('Closed at', static::formatDateStatic($inquiry->closed_at, 'Y-m-d H:i')),
            static::normalizeLine('Closed reason', $inquiry->closed_reason),
            static::normalizeLine('Concierge brief', $inquiry->concierge_brief ?? $inquiry->details),
        ])));

        $record->request_reference = $inquiry->request_reference;
        $record->guest_name = $inquiry->full_name;
        $record->guest_email = $inquiry->email;
        $record->guest_phone = $inquiry->phone;
        $record->country = $inquiry->country;
        $record->owner_name = $inquiry->owner_name ?: $operatorName;
        $record->service_focus_summary = $inquiry->services_inline ?: 'General planning';
        $record->source_summary = $sourceSummary !== '' ? $sourceSummary : 'Source context was limited on the originating inquiry.';
        $record->continuity_summary = $continuitySummary !== '' ? $continuitySummary : 'Inquiry continuity summary is still minimal.';
        $record->created_by = $record->created_by ?: ($operatorName ?: 'Operator');
        $record->continuity_status = $record->continuity_status ?: 'active_retention';
        $record->loyalty_stage = $record->loyalty_stage ?: 'review';
        $record->return_value_tier = $record->return_value_tier ?: 'watch';
        $record->return_value_candidate = !empty($record->return_value_candidate) || in_array((string) ($overrides['return_value_tier'] ?? $record->return_value_tier), ['promising', 'strong', 'flagship'], true);
        $record->next_review_at = $record->next_review_at ?: Carbon::now()->addDays(14);

        foreach ($overrides as $field => $value) {
            $record->{$field} = $value;
        }

        $record->save();

        if ($record->wasRecentlyCreated) {
            $record->appendTouchpoint(
                'system',
                'Created from inquiry continuity handoff' . ($inquiry->request_reference ? ' (' . $inquiry->request_reference . ')' : '') . '.',
                $operatorName,
                [
                    'touchpoint_outcome' => 'record_created',
                    'reference_code'     => $inquiry->request_reference,
                ]
            );
        }

        return $record;
    }

    protected function buildFinishReasonLine(): string
    {
        $latestTouchpoint = $this->getLatestTouchpointRecord();
        $latestOutcome = $latestTouchpoint ? (string) $latestTouchpoint->touchpoint_outcome : '';
        $executionStatus = $this->packet_execution_status_label;

        if ($this->latest_finish_lane_mode !== '') {
            return 'a finish lane is already explicitly parked, so the record now belongs in a monitored parked window rather than a new closure cycle';
        }

        if ($this->latest_closure_packet_mode !== '') {
            return 'A closure packet is already present, so the record now belongs in a monitored finish window rather than a new packet cycle';
        }

        if (in_array($executionStatus, ['No packet execution started', 'Prepared / awaiting follow-through', 'Follow-through in progress'], true)) {
            return 'the current packet loop is not finished yet, so closure should wait until the execution story is clearer';
        }

        if ($this->closure_packet_recommendation_label === 'Prepare referral closure packet') {
            return 'goodwill and referral posture are the strongest finish signals on the record';
        }

        if ($this->closure_packet_recommendation_label === 'Prepare return-value closure packet') {
            return 'the record now reads as a stewardship lane with elevated return-value handling';
        }

        if ($this->closure_packet_recommendation_label === 'Prepare reactivation closure packet') {
            return 'the latest outcome suggests re-engagement should be parked back into a review cadence';
        }

        if (in_array($latestOutcome, ['no_reply', 'dormant'], true)) {
            return 'the latest outcome does not justify a finish lane yet, so the record should stay in review posture';
        }

        return 'the record should remain in a narrow review posture until the next explicit signal is captured';
    }

    protected function buildTraceLine(string $label, ?LoyaltyTouchpoint $touchpoint, array &$seen): ?string
    {
        if (!$touchpoint || !$touchpoint->id || in_array($touchpoint->id, $seen, true)) {
            return null;
        }

        $seen[] = $touchpoint->id;

        $stamp = $touchpoint->touchpoint_at instanceof \DateTimeInterface
            ? $touchpoint->touchpoint_at->format('Y-m-d H:i')
            : (optional($touchpoint->created_at)->format('Y-m-d H:i') ?: 'Pending');

        $outcome = $touchpoint->touchpoint_outcome
            ? ($this->getTouchpointOutcomeOptions()[$touchpoint->touchpoint_outcome] ?? $this->humanizeValue($touchpoint->touchpoint_outcome) ?? 'Outcome pending')
            : 'Outcome pending';

        $channel = $touchpoint->touchpoint_channel
            ? ($this->getTouchpointChannelOptions()[$touchpoint->touchpoint_channel] ?? $this->humanizeValue($touchpoint->touchpoint_channel) ?? 'Channel pending')
            : 'Channel pending';

        $body = $this->firstMeaningfulLine($touchpoint->body ?: $touchpoint->touchpoint_summary, 'No narrative captured.');

        return sprintf('%s · %s · %s · %s · %s', $label, $stamp, $outcome, $channel, $body);
    }

    public function appendTouchpoint(string $type, string $body, ?string $authorName = null, array $meta = []): LoyaltyTouchpoint
    {
        $touchpoint = new LoyaltyTouchpoint();
        $touchpoint->loyalty_record_id = $this->id;
        $touchpoint->source_inquiry_id = $this->source_inquiry_id;
        $touchpoint->touchpoint_type = $type;
        $touchpoint->touchpoint_channel = $meta['touchpoint_channel'] ?? null;
        $touchpoint->touchpoint_outcome = $meta['touchpoint_outcome'] ?? null;
        $touchpoint->touchpoint_at = $meta['touchpoint_at'] ?? Carbon::now();
        $touchpoint->next_step_at = $meta['next_step_at'] ?? null;
        $touchpoint->author_name = $authorName ?: 'Operator';
        $touchpoint->operator_name = $touchpoint->author_name;
        $touchpoint->reference_code = $meta['reference_code'] ?? $this->request_reference;
        $touchpoint->body = trim($body);
        $touchpoint->touchpoint_summary = $touchpoint->body;
        $touchpoint->is_internal = array_key_exists('is_internal', $meta) ? (bool) $meta['is_internal'] : true;
        $touchpoint->payload_json = $meta['payload_json'] ?? null;

        if (static::touchpointStorageReady()) {
            $touchpoint->save();
        }

        $this->latestTouchpointCache = $touchpoint;
        $this->latestPreparedPacketTouchpointCache = false;
        $this->latestExecutionTouchpointCache = false;
        $this->latestClosurePacketTouchpointCache = false;
        $this->latestFinishLaneTouchpointCache = false;

        return $touchpoint;
    }

    protected function formatSummary(array $pairs, string $fallback): string
    {
        $lines = [];

        foreach ($pairs as $label => $value) {
            $value = $this->normalizeDisplayValue($value);

            if ($value === null) {
                continue;
            }

            $lines[] = $label . ': ' . $value;
        }

        return empty($lines) ? $fallback : implode(PHP_EOL, $lines);
    }

    protected function normalizeDisplayValue($value): ?string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i');
        }

        if (is_array($value)) {
            $value = implode(', ', array_filter(array_map('trim', $value)));
        }

        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }

    protected function humanizeValue($value): ?string
    {
        $value = $this->normalizeDisplayValue($value);

        if ($value === null) {
            return null;
        }

        return ucwords(str_replace(['_', '-'], ' ', $value));
    }


    protected function firstMeaningfulLine($value, string $fallback): string
    {
        $text = trim((string) $value);

        if ($text === '') {
            return $fallback;
        }

        foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
            $line = trim((string) $line);

            if ($line !== '') {
                return $line;
            }
        }

        return $fallback;
    }

    protected static function humanizeStatic($value): ?string
    {
        $value = trim((string) $value);

        return $value !== '' ? ucwords(str_replace(['_', '-'], ' ', $value)) : null;
    }

    protected static function formatDateStatic($value, string $format): ?string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format($format);
        }

        if (!$value) {
            return null;
        }

        try {
            return Carbon::parse($value)->format($format);
        } catch (\Throwable $e) {
            return trim((string) $value) ?: null;
        }
    }

    protected static function normalizeLine(string $label, $value): ?string
    {
        $value = is_array($value) ? implode(', ', array_filter(array_map('trim', $value))) : trim((string) $value);

        return $value !== '' ? $label . ': ' . $value : null;
    }
}
