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

    public static function workspaceRecordCount(): int
    {
        if (!static::workspaceStorageReady()) {
            return 0;
        }

        return (int) static::query()->count();
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

    public function getSourceInquiryBacklinkReferenceLabelAttribute(): string
    {
        if (!$this->source_inquiry) {
            return 'No source inquiry linked';
        }

        $reference = trim((string) $this->source_inquiry->request_reference);
        $guest = trim((string) $this->source_inquiry->full_name);

        if ($reference !== '' && $guest !== '') {
            return $reference . ' · ' . $guest;
        }

        if ($reference !== '') {
            return $reference;
        }

        if ($guest !== '') {
            return $guest;
        }

        return 'Linked inquiry';
    }

    public function getSourceInquiryBacklinkPostureLabelAttribute(): string
    {
        if (!$this->source_inquiry) {
            return 'Manual loyalty record';
        }

        $status = trim((string) $this->source_inquiry->status_label);
        $priority = trim((string) $this->source_inquiry->priority_label);

        if ($status !== '' && $priority !== '') {
            return $status . ' · ' . $priority;
        }

        if ($status !== '') {
            return $status;
        }

        if ($priority !== '') {
            return $priority;
        }

        return 'Source inquiry linked';
    }

    public function getSourceInquiryBacklinkHintAttribute(): string
    {
        if (!$this->source_inquiry) {
            return 'This record was created directly in Loyalty Continuity and does not point back to an originating inquiry.';
        }

        $parts = [];

        $owner = trim((string) ($this->source_inquiry->owner_display ?? ''));
        $queue = trim((string) ($this->source_inquiry->follow_up_queue_summary ?? ''));

        if ($owner !== '') {
            $parts[] = 'Owner: ' . $owner;
        }

        if ($queue !== '') {
            $parts[] = 'Queue: ' . $queue;
        }

        if (empty($parts)) {
            return 'Open the source inquiry to review its original queue posture and guest workflow context.';
        }

        return implode(' · ', $parts);
    }

    public function getSourceInquiryBacklinkUrlAttribute(): ?string
    {
        if (!$this->source_inquiry) {
            return null;
        }

        return \Backend::url('cabnet/mykonosinquiry/inquiries/update/' . $this->source_inquiry->id);
    }

    public function getSourceInquiryBacklinkActionLabelAttribute(): string
    {
        return $this->source_inquiry ? 'Open inquiry' : 'No source inquiry';
    }

    public function getSourceInquiryQueueReturnUrlAttribute(): string
    {
        if (!$this->source_inquiry) {
            return \Backend::url('cabnet/mykonosinquiry/inquiries');
        }

        return \Backend::url('cabnet/mykonosinquiry/inquiries') . '?' . http_build_query([
            'search' => trim((string) $this->source_inquiry->request_reference),
        ]);
    }

    public function getSourceInquiryQueueReturnLabelAttribute(): string
    {
        return $this->source_inquiry ? 'Back to queue search' : 'Open Inquiry Queue';
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


public function getFinishTriageLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopened / human review first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked watch / review now';
        }

        return 'Parked watch / stable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Close / park now';

        case 'Closure packet prepared':
            return 'Park finish lane';

        case 'Timed for later finish':
            return 'Timed watch';

        case 'Execution still open':
            return 'Execution active';

        case 'Prepared but not yet executed':
            return 'Prepared / execution pending';

        case 'Finish lane reopened':
            return 'Reopened / human review first';

        default:
            if ($this->packet_execution_status_label === 'Follow-through completed') {
                return 'Review finish posture';
            }

            return 'Review continuity';
    }
}

public function getFinishTriageUrgencyLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'High';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'High';
        }

        return 'Low';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'High';

        case 'Closure packet prepared':
        case 'Execution still open':
        case 'Prepared but not yet executed':
            return 'Medium';

        case 'Timed for later finish':
            return 'Low';

        default:
            return 'Medium';
    }
}

public function getStewardshipSnapshotCompressedAttribute(): string
{
    $nextReview = $this->next_review_at
        ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')'
        : 'Not scheduled';

    $parts = [
        'Triage: ' . $this->finish_triage_label,
        'Urgency: ' . $this->finish_triage_urgency_label,
        'Finish posture: ' . $this->stewardship_finish_posture_label,
        'Lane: ' . $this->finish_lane_status_label,
        'Watch: ' . $this->parked_lane_watch_label,
        'Next review: ' . $nextReview,
    ];

    return implode(' | ', $parts);
}

public function getFinishTriageDigestAttribute(): string
{
    return $this->formatSummary([
        'Finish triage' => $this->finish_triage_label,
        'Urgency' => $this->finish_triage_urgency_label,
        'Finish dashboard' => $this->finish_dashboard_status_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Next finish move' => $this->next_finish_move_label,
        'Latest closure packet' => $this->latest_closure_packet_label,
        'Latest finish lane' => $this->latest_finish_lane_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Reopen trigger' => $this->parked_lane_reopen_trigger_label,
        'Compressed snapshot' => $this->stewardship_snapshot_compressed,
    ], 'Finish triage digest is still minimal.');
}


public function getQueueCompressionBandLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopen review queue';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked watch due now';
        }

        return 'Parked watch stable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Finish packet queue';

        case 'Closure packet prepared':
            return 'Lane parking queue';

        case 'Execution still open':
            return 'Execution queue';

        case 'Prepared but not yet executed':
            return 'Prepared queue';

        case 'Timed for later finish':
            return 'Timed watch queue';

        default:
            if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
                return 'Review queue due now';
            }

            if ($this->next_review_at) {
                return 'Review queue';
            }

            return 'Quiet review queue';
    }
}

public function getListScanAidLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Review new proof';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Check parked lane now';
        }

        return 'Hold parked window';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Prepare finish packet';

        case 'Closure packet prepared':
            return 'Park finish lane';

        case 'Execution still open':
            return 'Complete follow-through';

        case 'Prepared but not yet executed':
            return 'Start follow-through';

        case 'Timed for later finish':
            return 'Wait for review window';

        default:
            if ($this->finish_triage_urgency_label === 'High') {
                return 'Review timing now';
            }

            return 'Hold continuity review';
    }
}

public function getOwnerTimingSignalLabelAttribute(): string
{
    $ownerPart = trim((string) $this->owner_name) !== '' ? 'Owner set' : 'Unassigned';

    if (!$this->next_review_at) {
        return $ownerPart . ' / no review set';
    }

    return $ownerPart . ' / ' . strtolower($this->next_review_window_label ?: 'review timed');
}

public function getStewardshipQueueCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Queue band' => $this->queue_compression_band_label,
        'Scan aid' => $this->list_scan_aid_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Finish triage' => $this->finish_triage_label,
        'Triage urgency' => $this->finish_triage_urgency_label,
        'Finish dashboard' => $this->finish_dashboard_status_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Next finish move' => $this->next_finish_move_label,
        'Compressed snapshot' => $this->stewardship_snapshot_compressed,
    ], 'Stewardship queue compression is still minimal.');
}

public function getStewardshipQueueScanFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Queue band: ' . $this->queue_compression_band_label . '.';
    $lines[] = 'Scan aid: ' . $this->list_scan_aid_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';
    $lines[] = 'Finish triage: ' . $this->finish_triage_label . ' with ' . $this->finish_triage_urgency_label . ' urgency.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is reopened, this record should sit near the top of the human review queue until fresh proof is interpreted.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the finish lane is parked but the review window is due, this record should be scanned early even though the lane is formally parked.';
        } else {
            $lines[] = 'Because the finish lane is parked and the watch window is stable, this record can stay quiet in the queue until the next review window or reopen trigger arrives.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because finish posture is ready, the next narrow move is to prepare the finish packet rather than keep this record buried in general review.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a closure packet already exists, the next narrow move is to park the finish lane deliberately so the stewardship state becomes explicit.';
    } elseif ($this->closure_readiness_label === 'Execution still open' || $this->closure_readiness_label === 'Prepared but not yet executed') {
        $lines[] = 'Because packet execution is still open, this record belongs in an active follow-through queue until the loop closes or the timing is deferred.';
    } else {
        $lines[] = 'Because finish posture is still emerging, this record should remain in a conservative review queue with narrow human-owned timing.';
    }

    return implode(PHP_EOL, $lines);
}


public function getOwnerHeldReturnCheckpointCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return compression bypassed / lane already reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return compression blocked / assign owner now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return compression active / overdue owner pull-back';

            case 'Due today':
                return 'Return compression active / same-day owner checkpoint';

            case 'Due soon':
                return 'Return compression staged / next-slot owner checkpoint';

            case 'Near-term':
                return 'Return compression staged / near-term owner checkpoint';

            case 'Future':
                return 'Return compression parked / future owner hold';

            case 'Unscheduled':
                return 'Return compression open / set owner checkpoint first';
        }

        return 'Return compression forming / quiet lane owner-held';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return compression narrow / drafting checkpoint owner-held';

        case 'Closure packet prepared':
            return 'Return compression narrow / finish choice owner-held';

        case 'Execution still open':
            return 'Return compression narrow / execution resume owner-held';

        case 'Prepared but not yet executed':
            return 'Return compression narrow / prepared resume owner-held';

        case 'Timed for later finish':
            return 'Return compression narrow / later finish owner hold';
    }

    return 'Return compression narrow / conservative owner-held read';
}

public function getSameDayQuietLaneAcknowledgementPolishLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Same-day acknowledgement bypassed / lane already reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Same-day acknowledgement blocked / owner still unnamed';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Same-day acknowledgement polished / overdue move acknowledged';

            case 'Due today':
                return 'Same-day acknowledgement polished / same-day move acknowledged';

            case 'Due soon':
                return 'Same-day acknowledgement staged / next-slot acknowledgement';

            case 'Near-term':
                return 'Same-day acknowledgement staged / near-term acknowledgement';

            case 'Future':
                return 'Same-day acknowledgement parked / future quiet hold';

            case 'Unscheduled':
                return 'Same-day acknowledgement open / set review timing first';
        }

        return 'Same-day acknowledgement forming / quiet lane readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Same-day acknowledgement narrow / drafting move acknowledged';

        case 'Closure packet prepared':
            return 'Same-day acknowledgement narrow / finish choice acknowledged';

        case 'Execution still open':
            return 'Same-day acknowledgement narrow / execution resume acknowledged';

        case 'Prepared but not yet executed':
            return 'Same-day acknowledgement narrow / prepared resume acknowledged';

        case 'Timed for later finish':
            return 'Same-day acknowledgement narrow / timed quiet hold';
    }

    return 'Same-day acknowledgement narrow / conservative quiet-lane read';
}

public function getOwnerHeldReturnCheckpointCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-held return checkpoint compression' => $this->owner_held_return_checkpoint_compression_label,
        'Same-day quiet-lane acknowledgement polish' => $this->same_day_quiet_lane_acknowledgement_polish_label,
        'Owner-confirmed same-day handback cue' => $this->owner_confirmed_same_day_handback_cue_label,
        'Quiet-lane return checkpoint polish' => $this->quiet_lane_return_checkpoint_polish_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-held return checkpoint compression digest is still minimal.');
}

public function getSameDayQuietLaneAcknowledgementPolishFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-held return checkpoint compression: ' . $this->owner_held_return_checkpoint_compression_label . '.';
    $lines[] = 'Same-day quiet-lane acknowledgement polish: ' . $this->same_day_quiet_lane_acknowledgement_polish_label . '.';
    $lines[] = 'Owner-confirmed same-day handback cue: ' . $this->owner_confirmed_same_day_handback_cue_label . '.';
    $lines[] = 'Quiet-lane return checkpoint polish: ' . $this->quiet_lane_return_checkpoint_polish_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, return checkpoint compression should collapse into active handling instead of quiet framing. The same-day acknowledgement polish simply keeps the reopened move explicit across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no owner, the return checkpoint cannot compress truthfully yet. The first real move is to name the operator so the same-day acknowledgement can become believable across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress down to one owner-held return checkpoint and one explicit same-day acknowledgement. This keeps the overdue pull-back readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-held checkpoint and one same-day acknowledgement. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, the checkpoint can stay compressed and owner-held before urgency rises. The acknowledgement polish keeps the next same-day interpretation ready without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The checkpoint compression holds the next control point in one place, while the acknowledgement polish keeps the likely same-day move readable across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the checkpoint stays compressed and parked. The acknowledgement polish exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, the same-day acknowledgement cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one owner-held control point and one believable acknowledgement.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, checkpoint compression should keep the drafting return tied to one owner-held control point. The acknowledgement polish keeps that likely same-day move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, checkpoint compression should stay tied to the finish-choice control point. The acknowledgement polish keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, checkpoint compression should keep the next resume control point owner-held. The acknowledgement polish makes that same-day resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, the checkpoint remains compressed and scheduled. The acknowledgement polish simply keeps the eventual same-day return understandable without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-held return checkpoint compression and same-day quiet-lane acknowledgement polish remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getFrontOfQueueParkedLaneSeparationLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Front of queue / reopened lane already active';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Front of queue / owner missing on immediate review';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Front of queue / parked lane expired into review';

            case 'Due today':
                return 'Front of queue / same-shift parked review';

            case 'Due soon':
                return 'Near front / next-slot parked review';

            case 'Near-term':
                return 'Mid queue / visible parked lane';

            case 'Future':
                return 'Parked lane / future hold stays separated';

            case 'Unscheduled':
                return 'Unsorted / parked lane needs timing';
        }

        return 'Queue separation forming / parked lane still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Front of queue / close-side execution still open';

        case 'Ready for finish packet':
            return 'Near front / finish drafting belongs ahead of parking';

        case 'Closure packet prepared':
            return 'Near front / finish choice belongs ahead of parking';

        case 'Prepared but not yet executed':
            return 'Near front / prepared work belongs ahead of parking';

        case 'Timed for later finish':
            return 'Parked lane / timed finish hold stays separated';
    }

    return 'Queue separation conservative / front and parked lanes readable';
}

public function getOwnerStateHandoffCompressionLabelAttribute(): string
{
    if (trim((string) $this->owner_name) === '') {
        if ($this->latest_finish_lane_state === 'reopened') {
            return 'Owner handoff open / reopened lane needs named lead';
        }

        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Owner handoff open / overdue lane needs assignment';

            case 'Due today':
                return 'Owner handoff open / same-shift lane needs assignment';

            case 'Due soon':
                return 'Owner handoff open / due-soon lane can wait briefly';

            case 'Near-term':
                return 'Owner handoff open / near-term parked lane';

            case 'Future':
                return 'Owner handoff open / future parked hold';

            case 'Unscheduled':
                return 'Owner handoff open / assign owner and timing';
        }

        return 'Owner handoff open / lane ownership still forming';
    }

    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Owner handoff compressed / active owner resumes now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Owner handoff compressed / current owner returns now';

            case 'Due today':
                return 'Owner handoff compressed / same-shift owner return';

            case 'Due soon':
                return 'Owner handoff compressed / next owner slot visible';

            case 'Near-term':
                return 'Owner handoff compressed / queued owner slot';

            case 'Future':
                return 'Owner handoff compressed / future parked owner hold';

            case 'Unscheduled':
                return 'Owner handoff incomplete / owner set but slot missing';
        }

        return 'Owner handoff compressed / parked lane ownership readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Owner handoff compressed / execution owner moves next';

        case 'Ready for finish packet':
            return 'Owner handoff compressed / drafting owner moves next';

        case 'Closure packet prepared':
            return 'Owner handoff compressed / finish-choice owner moves next';

        case 'Prepared but not yet executed':
            return 'Owner handoff compressed / prepared owner resumes next';

        case 'Timed for later finish':
            return 'Owner handoff compressed / timed owner hold';
    }

    return 'Owner handoff compressed / conservative owner-state read';
}

public function getFrontOfQueueParkedLaneSeparationDigestAttribute(): string
{
    return $this->formatSummary([
        'Front-of-queue versus parked-lane separation' => $this->front_of_queue_parked_lane_separation_label,
        'Owner-state handoff compression' => $this->owner_state_handoff_compression_label,
        'Same-shift handoff sequence' => $this->same_shift_handoff_sequence_label,
        'Queue backlog compression' => $this->queue_backlog_compression_label,
        'Queue backlog visibility' => $this->queue_backlog_visibility_label,
        'Deliberate reopen priority' => $this->deliberate_reopen_priority_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Front-of-queue versus parked-lane separation digest is still minimal.');
}

public function getOwnerStateHandoffCompressionFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Front-of-queue versus parked-lane separation: ' . $this->front_of_queue_parked_lane_separation_label . '.';
    $lines[] = 'Owner-state handoff compression: ' . $this->owner_state_handoff_compression_label . '.';
    $lines[] = 'Same-shift handoff sequence: ' . $this->same_shift_handoff_sequence_label . '.';
    $lines[] = 'Queue backlog compression: ' . $this->queue_backlog_compression_label . '.';
    $lines[] = 'Queue backlog visibility: ' . $this->queue_backlog_visibility_label . '.';
    $lines[] = 'Deliberate reopen priority: ' . $this->deliberate_reopen_priority_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, the record no longer belongs in a parked-lane reading. The separation cue should collapse to the front of the queue, and owner-state handoff compression should simply confirm which named operator now owns the active return.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record has already entered an immediate review window but still has no named owner, queue separation should not pretend the lane is safely parked. The next human move is to assign ownership first so the front-of-queue read and the owner handoff read can become believable together.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the record should separate clearly out of the parked lane and into the front of the queue. Owner-state handoff compression exists to keep that overdue return attached to one current operator without widening the workflow into automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked review window is due today, the record should read as same-shift front-of-queue work rather than a quiet parked hold. The owner-state handoff cue keeps that same-shift return narrow, named, and easy to confirm across the loyalty list, overview workspace, and linked inquiry snapshot.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked review window is approaching, the record should stay near the front without pretending it is already urgent now. The owner-state handoff cue keeps the next human lead visible early so the parked lane can compress honestly before the window tightens.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the review window is near-term, the workspace can keep the record visibly separated from deeper parked backlog while still remaining calm. Owner-state handoff compression keeps the likely next lead readable without overstating urgency.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the review window is still future-facing, the record can remain parked as a quiet hold. The separation cue exists so future parked work does not get confused with front-of-queue items, and the owner-state handoff cue simply preserves who should receive that later return.';
        } else {
            $lines[] = 'Because the parked lane still lacks usable timing, queue separation cannot fully settle. The next human move is to assign a real review slot so the front-versus-parked distinction and the owner handoff can both compress into one credible reading.';
        }
    } elseif ($this->closure_readiness_label === 'Execution still open') {
        $lines[] = 'Because close-side execution is still open, the record belongs ahead of quiet parked backlog until that follow-through is resolved. Owner-state handoff compression keeps the execution lead explicit so the queue stays readable without turning into automation.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for finish drafting, it belongs ahead of passive parked items even if the lane is otherwise quiet. The owner-state handoff cue keeps that drafting move attached to one lead so the next operator decision remains easy to scan.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, the record belongs in a near-front decision lane rather than a deep parked hold. Owner-state handoff compression keeps the finish-choice owner explicit across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif ($this->closure_readiness_label === 'Prepared but not yet executed') {
        $lines[] = 'Because prepared work still needs a deliberate operator move, the record should stay ahead of passive parked backlog. The owner-state handoff cue keeps that prepared resume move narrow and named without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, the record can remain credibly parked. The separation cue keeps that hold distinct from front-of-queue work, and the owner-state handoff cue simply preserves who should receive the future handback.';
    } else {
        $lines[] = 'Because the workspace is still conservative and human-led, front-of-queue versus parked-lane separation and owner-state handoff compression remain narrow scan aids only. They reduce translation between urgency, parking, and ownership without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getReopenTimingDisciplineLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopen timing active / immediate proof review window';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Reopen timing blocked / assign owner before due review';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Reopen timing escalated / parked review overdue now';

            case 'Due today':
                return 'Reopen timing active / same-shift checkpoint due';

            case 'Due soon':
                return 'Reopen timing staged / next-slot checkpoint approaching';

            case 'Near-term':
                return 'Reopen timing staged / near-term parked checkpoint';

            case 'Future':
                return 'Reopen timing parked / future checkpoint preserved';

            case 'Unscheduled':
                return 'Reopen timing open / set checkpoint before reopen read';
        }

        return 'Reopen timing forming / parked-lane timing still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Reopen timing deferred / close-side execution still active';

        case 'Ready for finish packet':
            return 'Reopen timing pending / finish drafting before parking';

        case 'Closure packet prepared':
            return 'Reopen timing pending / deliberate lane parking next';

        case 'Prepared but not yet executed':
            return 'Reopen timing pending / prepared follow-through first';

        case 'Timed for later finish':
            return 'Reopen timing scheduled / later finish window preserved';
    }

    return 'Reopen timing conservative / quiet review timing still forming';
}

public function getSameShiftReviewCheckpointConfirmationLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Checkpoint confirmed / same-shift reopened review';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Checkpoint unconfirmed / same-shift owner still missing';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Checkpoint confirmed / overdue parked review pulled into shift';

            case 'Due today':
                return 'Checkpoint confirmed / same-shift quiet return due';

            case 'Due soon':
                return 'Checkpoint pre-confirmed / next-slot review prepared';

            case 'Near-term':
                return 'Checkpoint staged / later-shift review named';

            case 'Future':
                return 'Checkpoint parked / future review held';

            case 'Unscheduled':
                return 'Checkpoint open / set review timing first';
        }

        return 'Checkpoint forming / same-shift read still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
        case 'Prepared but not yet executed':
            return 'Checkpoint confirmed / current-shift follow-through';

        case 'Ready for finish packet':
            return 'Checkpoint confirmed / drafting review this shift';

        case 'Closure packet prepared':
            return 'Checkpoint confirmed / finish-choice review this shift';

        case 'Timed for later finish':
            return 'Checkpoint staged / later-finish review preserved';
    }

    return 'Checkpoint conservative / same-shift read still forming';
}

public function getReopenTimingDisciplineDigestAttribute(): string
{
    return $this->formatSummary([
        'Reopen timing discipline' => $this->reopen_timing_discipline_label,
        'Same-shift checkpoint confirmation' => $this->same_shift_review_checkpoint_confirmation_label,
        'Queue separation' => $this->front_of_queue_parked_lane_separation_label,
        'Owner-state handoff' => $this->owner_state_handoff_compression_label,
        'Same-shift handoff' => $this->same_shift_handoff_sequence_label,
        'Reopen priority' => $this->deliberate_reopen_priority_label,
        'Queue watch' => $this->queue_watch_readiness_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Reopen timing discipline digest is still minimal.');
}

public function getSameShiftReviewCheckpointConfirmationFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Reopen timing discipline: ' . $this->reopen_timing_discipline_label . '.';
    $lines[] = 'Same-shift review checkpoint confirmation: ' . $this->same_shift_review_checkpoint_confirmation_label . '.';
    $lines[] = 'Queue separation: ' . $this->front_of_queue_parked_lane_separation_label . '.';
    $lines[] = 'Owner-state handoff: ' . $this->owner_state_handoff_compression_label . '.';
    $lines[] = 'Same-shift handoff: ' . $this->same_shift_handoff_sequence_label . '.';
    $lines[] = 'Reopen priority: ' . $this->deliberate_reopen_priority_label . '.';
    $lines[] = 'Queue watch: ' . $this->queue_watch_readiness_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, reopen timing discipline should collapse into immediate proof review and the same-shift checkpoint should read as already active. The purpose is to keep the reopened record clearly human-owned and easy to scan across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record has already entered an immediate review window but still has no named owner, timing discipline cannot honestly compress yet. The first real move is to assign the operator so the same-shift checkpoint becomes believable instead of leaving due review work parked in ambiguity.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked checkpoint is overdue, reopen timing discipline should escalate the record into deliberate human review now. The same-shift checkpoint confirmation exists so that overdue pull-back reads as current-shift work rather than deeper parked backlog.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked checkpoint lands today, reopen timing discipline should stay active and the same-shift checkpoint should read as confirmed. That keeps the quiet return explicit without widening the workflow into automation.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the checkpoint is approaching but not yet immediate, timing discipline can stay staged while the next-slot review remains pre-confirmed. The goal is to preserve a clean early read without falsely promoting it above the current-day work.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the checkpoint is near-term rather than same-shift, timing discipline should remain calm and the checkpoint should stay staged for a later operator pass. This keeps the record visible without flattening every parked lane into urgency.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the checkpoint belongs to a future quiet slot, timing discipline should remain parked and the same-shift checkpoint should not overstate immediacy. The framing simply preserves when and how the later review should surface.';
        } else {
            $lines[] = 'Because the parked lane still lacks usable timing, reopen timing discipline cannot settle fully yet. The next safe move is to name a real checkpoint so the same-shift read becomes credible across every surface.';
        }
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs follow-through, reopen timing discipline should stay secondary and the same-shift checkpoint should point to the current operator pass. The record belongs in active human handling until the open loop narrows or the timing is deliberately parked.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for finish drafting, the same-shift checkpoint can stay confirmed around the drafting pass while reopen timing remains pending. This keeps finish-ready work readable without pretending the lane is already parked.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a closure packet already exists, the checkpoint can stay confirmed for the finish-choice pass while reopen timing remains a secondary parked-lane concern. The narrow read is to resolve the deliberate lane decision before adding more timing complexity.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, reopen timing discipline should stay scheduled and the same-shift checkpoint should remain staged rather than active. The cue exists to keep later work understandable without crowding the current shift.';
    } else {
        $lines[] = 'Because the workspace is still conservative and human-led, reopen timing discipline and same-shift review checkpoint confirmation remain narrow scan aids only. They tighten queue reading without changing the underlying inquiry workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getParkedLaneOwnerReassignmentVisibilityLabelAttribute(): string
{
    $ownerMissing = trim((string) $this->owner_name) === '';
    $reviewWindow = $this->next_review_window_label;

    if ($this->latest_finish_lane_state === 'reopened') {
        return $ownerMissing
            ? 'Owner reassignment urgent / reopened lane needs named operator'
            : 'Owner reassignment settled / reopened lane stays with current owner';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if ($ownerMissing) {
            switch ($reviewWindow) {
                case 'Overdue':
                    return 'Owner reassignment urgent / parked lane overdue and unowned';

                case 'Due today':
                    return 'Owner reassignment urgent / same-shift parked return unowned';

                case 'Due soon':
                    return 'Owner reassignment pending / next-slot parked owner missing';

                case 'Near-term':
                    return 'Owner reassignment visible / near-term parked owner still open';

                case 'Future':
                    return 'Owner reassignment queued / future parked owner still open';

                case 'Unscheduled':
                    return 'Owner reassignment blocked / parked lane missing owner and timing';
            }

            return 'Owner reassignment forming / parked lane ownership still open';
        }

        switch ($reviewWindow) {
            case 'Overdue':
                return 'Owner reassignment visible / overdue parked return stays named';

            case 'Due today':
                return 'Owner reassignment visible / same-shift parked return stays named';

            case 'Due soon':
                return 'Owner reassignment visible / next-slot parked owner named';

            case 'Near-term':
                return 'Owner reassignment visible / near-term parked owner preserved';

            case 'Future':
                return 'Owner reassignment visible / future parked owner preserved';

            case 'Unscheduled':
                return 'Owner reassignment partial / parked owner named but timing open';
        }

        return 'Owner reassignment visible / parked-lane ownership readable';
    }

    if ($ownerMissing && in_array($reviewWindow, ['Overdue', 'Due today'], true)) {
        return 'Owner reassignment urgent / immediate review lane still unowned';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return $ownerMissing
                ? 'Owner reassignment pending / execution lane needs lead'
                : 'Owner reassignment minimal / execution lead already named';

        case 'Ready for finish packet':
            return $ownerMissing
                ? 'Owner reassignment pending / finish drafting lead missing'
                : 'Owner reassignment minimal / drafting lead already named';

        case 'Closure packet prepared':
            return $ownerMissing
                ? 'Owner reassignment pending / finish-choice lead missing'
                : 'Owner reassignment minimal / finish-choice lead already named';

        case 'Prepared but not yet executed':
            return $ownerMissing
                ? 'Owner reassignment pending / prepared follow-through lead missing'
                : 'Owner reassignment minimal / prepared lead already named';

        case 'Timed for later finish':
            return $ownerMissing
                ? 'Owner reassignment queued / timed finish owner still open'
                : 'Owner reassignment preserved / timed finish owner named';
    }

    return $ownerMissing
        ? 'Owner reassignment open / quiet review owner still missing'
        : 'Owner reassignment minimal / current owner already readable';
}

public function getFrontOfListQuietReturnConfirmationLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Front-of-list quiet return confirmed / reopened review now';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Front-of-list quiet return blocked / assign owner before confirm';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Front-of-list quiet return confirmed / parked lane due now';

            case 'Due today':
                return 'Front-of-list quiet return confirmed / same-shift quiet return';

            case 'Due soon':
                return 'Front-of-list quiet return staged / near-front quiet return next';

            case 'Near-term':
                return 'Front-of-list quiet return visible / later-shift quiet return held';

            case 'Future':
                return 'Front-of-list quiet return parked / future slot preserved';

            case 'Unscheduled':
                return 'Front-of-list quiet return open / timing missing before confirmation';
        }

        return 'Front-of-list quiet return forming / parked timing still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Front-of-list quiet return deferred / active execution still ahead';

        case 'Ready for finish packet':
            return 'Front-of-list quiet return deferred / finish drafting first';

        case 'Closure packet prepared':
            return 'Front-of-list quiet return deferred / finish-choice lane first';

        case 'Prepared but not yet executed':
            return 'Front-of-list quiet return deferred / prepared follow-through first';

        case 'Timed for later finish':
            return 'Front-of-list quiet return parked / timed finish window preserved';
    }

    return 'Front-of-list quiet return conservative / quiet review ordering still forming';
}

public function getParkedLaneOwnerReassignmentVisibilityDigestAttribute(): string
{
    return $this->formatSummary([
        'Parked-lane owner reassignment visibility' => $this->parked_lane_owner_reassignment_visibility_label,
        'Front-of-list quiet-return confirmation' => $this->front_of_list_quiet_return_confirmation_label,
        'Owner-state handoff' => $this->owner_state_handoff_compression_label,
        'Reopen timing discipline' => $this->reopen_timing_discipline_label,
        'Same-shift checkpoint confirmation' => $this->same_shift_review_checkpoint_confirmation_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Queue separation' => $this->front_of_queue_parked_lane_separation_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Parked-lane owner reassignment visibility digest is still minimal.');
}

public function getFrontOfListQuietReturnConfirmationFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Parked-lane owner reassignment visibility: ' . $this->parked_lane_owner_reassignment_visibility_label . '.';
    $lines[] = 'Front-of-list quiet-return confirmation: ' . $this->front_of_list_quiet_return_confirmation_label . '.';
    $lines[] = 'Owner-state handoff: ' . $this->owner_state_handoff_compression_label . '.';
    $lines[] = 'Reopen timing discipline: ' . $this->reopen_timing_discipline_label . '.';
    $lines[] = 'Same-shift checkpoint confirmation: ' . $this->same_shift_review_checkpoint_confirmation_label . '.';
    $lines[] = 'Quiet-lane return: ' . $this->quiet_lane_return_label . '.';
    $lines[] = 'Queue separation: ' . $this->front_of_queue_parked_lane_separation_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, owner reassignment visibility should collapse to whether one named operator now owns the active return. Front-of-list quiet-return confirmation should then read as fully confirmed, because the record has already left passive parking and returned to deliberate human review.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record has already reached an immediate review window but still has no named owner, the workspace should not pretend the quiet return is fully confirmed. The first safe move is to assign the operator so owner reassignment visibility and front-of-list return confirmation become believable together across the list, overview workspace, and linked inquiry snapshot.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the record should stop reading as safely parked. Owner reassignment visibility exists so the overdue quiet return stays attached to one human lead, and front-of-list confirmation exists so the return is read as current front-of-queue work rather than deeper backlog.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked review window lands today, the quiet return should read as same-shift front-of-list work. Owner reassignment visibility keeps the current operator handoff explicit, while front-of-list confirmation compresses the return into one narrow, believable human review move.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked review window is approaching, the workspace can keep the record near the front without overstating it as immediate. Owner reassignment visibility keeps the likely next operator readable early, and front-of-list confirmation keeps the upcoming quiet return visible before it becomes urgent.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the quiet return is near-term rather than same-shift, the workspace should keep the record visible without flattening it into active urgency. Owner reassignment visibility preserves who should receive that later return, and front-of-list confirmation stays provisional instead of absolute.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return sits in a future quiet slot, the record can remain parked. The owner reassignment cue simply preserves who should receive that later handback, while front-of-list confirmation stays intentionally parked so future work does not displace current-shift review.';
        } else {
            $lines[] = 'Because the parked lane still lacks usable timing, neither owner reassignment visibility nor front-of-list confirmation can settle honestly yet. The next safe move is to name both the owner and the review slot so the quiet return becomes credible on every backend surface.';
        }
    } elseif ($this->closure_readiness_label === 'Execution still open') {
        $lines[] = 'Because close-side execution is still active, the record should stay ahead of quiet-return parking for now. Owner reassignment visibility simply confirms whether that active work already has a named lead, and front-of-list confirmation stays deferred until the execution story settles.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for finish drafting, the workspace should keep the drafting move ahead of passive quiet-return parking. Owner reassignment visibility keeps the drafting lead explicit, and front-of-list quiet-return confirmation remains deferred until the drafting choice is complete.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a finish-choice packet is already prepared, the record belongs in a near-front decision lane rather than a quiet parked hold. Owner reassignment visibility keeps the decision lead readable, and front-of-list quiet-return confirmation waits until the operator deliberately chooses whether the lane stays parked or returns now.';
    } elseif ($this->closure_readiness_label === 'Prepared but not yet executed') {
        $lines[] = 'Because prepared work still needs a deliberate operator move, the record should stay ahead of passive parked backlog. The owner reassignment cue keeps that prepared resume move attached to one lead, while front-of-list quiet-return confirmation remains deferred until the prepared work is actually resumed or parked.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because finish timing is intentionally deferred, the record can remain parked without being mistaken for front-of-list work. Owner reassignment visibility simply preserves who should receive that later handback, and front-of-list quiet-return confirmation stays intentionally parked.';
    } else {
        $lines[] = 'Because the loyalty workspace stays conservative and human-led, parked-lane owner reassignment visibility and front-of-list quiet-return confirmation remain narrow scan aids only. They reduce translation between parking, ownership, and near-front review without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getOwnerVisibleDeferredReviewSlotAlignmentLabelAttribute(): string
{
    $ownerMissing = trim((string) $this->owner_name) === '';

    if ($this->latest_finish_lane_state === 'reopened') {
        if ($ownerMissing) {
            return 'Deferred review-slot alignment blocked / reopened lane still needs owner';
        }

        switch ($this->next_review_window_label) {
            case 'Overdue':
            case 'Due today':
                return 'Deferred review-slot alignment resolved / reopened owner aligned now';

            case 'Due soon':
                return 'Deferred review-slot alignment visible / reopened owner aligned for next slot';

            case 'Near-term':
                return 'Deferred review-slot alignment visible / owner named for later slot';

            case 'Future':
                return 'Deferred review-slot alignment preserved / future owner slot named';

            case 'Unscheduled':
                return 'Deferred review-slot alignment partial / owner named but slot missing';
        }

        return 'Deferred review-slot alignment resolved / reopened owner readable';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if ($ownerMissing) {
            switch ($this->next_review_window_label) {
                case 'Overdue':
                    return 'Deferred review-slot alignment blocked / overdue parked return still unowned';

                case 'Due today':
                    return 'Deferred review-slot alignment blocked / same-shift parked return still unowned';

                case 'Due soon':
                    return 'Deferred review-slot alignment pending / next quiet slot still needs owner';

                case 'Near-term':
                    return 'Deferred review-slot alignment pending / later quiet slot still needs owner';

                case 'Future':
                    return 'Deferred review-slot alignment pending / future parked slot owner missing';

                case 'Unscheduled':
                    return 'Deferred review-slot alignment open / owner and slot both need alignment';
            }

            return 'Deferred review-slot alignment pending / owner still missing for parked return';
        }

        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Deferred review-slot alignment resolved / owner-visible overdue slot';

            case 'Due today':
                return 'Deferred review-slot alignment resolved / owner-visible same-shift slot';

            case 'Due soon':
                return 'Deferred review-slot alignment aligned / owner-visible next-slot return';

            case 'Near-term':
                return 'Deferred review-slot alignment aligned / owner-visible deferred slot';

            case 'Future':
                return 'Deferred review-slot alignment preserved / owner-visible future slot';

            case 'Unscheduled':
                return 'Deferred review-slot alignment partial / owner visible but slot missing';
        }

        return 'Deferred review-slot alignment aligned / owner and deferred slot readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return $ownerMissing
                ? 'Deferred review-slot alignment deferred / active execution still unowned'
                : 'Deferred review-slot alignment deferred / active execution lead already named';

        case 'Ready for finish packet':
            return $ownerMissing
                ? 'Deferred review-slot alignment deferred / finish drafting owner missing'
                : 'Deferred review-slot alignment deferred / finish drafting lead already named';

        case 'Closure packet prepared':
            return $ownerMissing
                ? 'Deferred review-slot alignment deferred / finish-choice owner missing'
                : 'Deferred review-slot alignment deferred / finish-choice lead already named';

        case 'Prepared but not yet executed':
            return $ownerMissing
                ? 'Deferred review-slot alignment deferred / prepared follow-through owner missing'
                : 'Deferred review-slot alignment deferred / prepared lead already named';

        case 'Timed for later finish':
            return $ownerMissing
                ? 'Deferred review-slot alignment queued / timed finish owner still open'
                : 'Deferred review-slot alignment preserved / timed finish owner and slot readable';
    }

    return $ownerMissing
        ? 'Deferred review-slot alignment open / owner and timing still forming'
        : 'Deferred review-slot alignment conservative / owner visible but deferred slot still light';
}

public function getCurrentShiftNextShiftQuietReturnSeparationLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Current-shift versus next-shift quiet-return separation resolved / reopened now';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Current-shift versus next-shift quiet-return separation blocked / assign owner before same-shift return';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Current-shift versus next-shift quiet-return separation resolved / overdue return belongs current shift';

            case 'Due today':
                return 'Current-shift versus next-shift quiet-return separation resolved / same-shift quiet return';

            case 'Due soon':
                return 'Current-shift versus next-shift quiet-return separation staged / next-shift quiet return visible';

            case 'Near-term':
                return 'Current-shift versus next-shift quiet-return separation staged / later-shift quiet return preserved';

            case 'Future':
                return 'Current-shift versus next-shift quiet-return separation parked / future-shift quiet return held';

            case 'Unscheduled':
                return 'Current-shift versus next-shift quiet-return separation open / shift split unclear until timing is set';
        }

        return 'Current-shift versus next-shift quiet-return separation forming / parked timing still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Current-shift versus next-shift quiet-return separation deferred / active execution still ahead';

        case 'Ready for finish packet':
            return 'Current-shift versus next-shift quiet-return separation deferred / finish drafting first';

        case 'Closure packet prepared':
            return 'Current-shift versus next-shift quiet-return separation deferred / finish-choice lane first';

        case 'Prepared but not yet executed':
            return 'Current-shift versus next-shift quiet-return separation deferred / prepared follow-through first';

        case 'Timed for later finish':
            return 'Current-shift versus next-shift quiet-return separation parked / timed finish window preserved';
    }

    return 'Current-shift versus next-shift quiet-return separation conservative / shift split still forming';
}

public function getOwnerVisibleDeferredReviewSlotAlignmentDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-visible deferred review-slot alignment' => $this->owner_visible_deferred_review_slot_alignment_label,
        'Current-shift versus next-shift quiet-return separation' => $this->current_shift_next_shift_quiet_return_separation_label,
        'Owner reassignment' => $this->parked_lane_owner_reassignment_visibility_label,
        'Front-of-list quiet return' => $this->front_of_list_quiet_return_confirmation_label,
        'Review sequence' => $this->owner_review_slot_sequence_label,
        'Checkpoint confirmation' => $this->same_shift_review_checkpoint_confirmation_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Owner-visible deferred review-slot alignment digest is still minimal.');
}

public function getCurrentShiftNextShiftQuietReturnSeparationFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-visible deferred review-slot alignment: ' . $this->owner_visible_deferred_review_slot_alignment_label . '.';
    $lines[] = 'Current-shift versus next-shift quiet-return separation: ' . $this->current_shift_next_shift_quiet_return_separation_label . '.';
    $lines[] = 'Owner reassignment: ' . $this->parked_lane_owner_reassignment_visibility_label . '.';
    $lines[] = 'Front-of-list quiet return: ' . $this->front_of_list_quiet_return_confirmation_label . '.';
    $lines[] = 'Review sequence: ' . $this->owner_review_slot_sequence_label . '.';
    $lines[] = 'Checkpoint confirmation: ' . $this->same_shift_review_checkpoint_confirmation_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, deferred-slot alignment should collapse into one immediate owner-visible return. The shift-separation cue should therefore read as resolved now instead of pretending there is still a quiet next-shift handback to interpret.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record has already entered a same-shift review window but still has no named owner, the workspace should not pretend the quiet return is cleanly aligned. The first safe move is to assign the operator so deferred-slot alignment and shift separation become believable together across the list, overview workspace, and linked inquiry snapshot.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the record no longer belongs in a deferred next-shift reading. Owner-visible deferred-slot alignment exists so the overdue return stays attached to one human lead, and shift separation exists so the queue clearly reads this as current-shift work now.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked review window lands today, the record belongs in a same-shift quiet-return lane rather than a later handback. Deferred-slot alignment keeps the named operator and the review slot compressed into one believable read, while shift separation makes it obvious that the return should not be pushed into the next shift.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked review window is close but not yet same-shift urgent, the workspace can keep the quiet return visible as next-shift work. Deferred-slot alignment keeps the likely owner readable early, while shift separation prevents the record from being mistaken for immediate current-shift review.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term rather than immediate, the workspace should preserve a deferred owner-visible slot without flattening it into current-shift urgency. Shift separation keeps that later quiet return distinct from both same-shift work and deep future parking.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet return is still future-facing, the record can remain parked. Deferred-slot alignment simply preserves which owner should receive the later handback, while shift separation keeps future quiet work from displacing current-shift or next-shift review.';
        } else {
            $lines[] = 'Because the parked lane still lacks usable timing, neither deferred-slot alignment nor shift separation can settle honestly yet. The next safe move is to name the owner and assign a credible review slot so the workspace can distinguish current-shift, next-shift, and later quiet returns without guesswork.';
        }
    } elseif ($this->closure_readiness_label === 'Execution still open') {
        $lines[] = 'Because close-side execution is still active, the record should stay ahead of quiet-return slotting for now. Deferred-slot alignment simply confirms whether the current execution lead is already visible, and shift separation stays deferred until the execution story closes or parks.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for finish drafting, the workspace should keep the drafting move ahead of deferred quiet-return alignment. The shift-separation cue therefore stays conservative until the drafting decision resolves into either current-shift work or a later parked return.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a finish-choice packet is already prepared, the record belongs in a near-front decision lane rather than a settled deferred slot. Owner-visible alignment keeps the next human lead explicit, and shift separation waits until the operator deliberately decides whether the quiet return belongs this shift or later.';
    } elseif ($this->closure_readiness_label === 'Prepared but not yet executed') {
        $lines[] = 'Because prepared work still needs a deliberate operator move, the record should stay ahead of passive quiet-return slotting. Deferred-slot alignment and shift separation remain narrow reading aids only until the prepared work is either resumed now or consciously parked into a later slot.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because finish timing is intentionally deferred, the record can remain parked without pretending it belongs to the current shift. Deferred-slot alignment simply preserves who should receive that later return, and shift separation keeps the later quiet move distinct from same-shift or next-shift review.';
    } else {
        $lines[] = 'Because the loyalty workspace stays conservative and human-led, owner-visible deferred-slot alignment and current-shift versus next-shift quiet-return separation remain narrow scan aids only. They reduce translation between ownership, timing, and quiet-return placement without widening the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getParkedLaneHandbackSequencingVisibilityLabelAttribute(): string
{
    $ownerMissing = trim((string) $this->owner_name) === '';

    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Parked-lane handback sequencing visibility collapsed / reopened now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if ($ownerMissing) {
            switch ($this->next_review_window_label) {
                case 'Overdue':
                    return 'Parked-lane handback sequencing visibility blocked / overdue handback still unowned';

                case 'Due today':
                    return 'Parked-lane handback sequencing visibility blocked / same-shift handback still unowned';

                case 'Due soon':
                    return 'Parked-lane handback sequencing visibility pending / next-shift handback still needs owner';

                case 'Near-term':
                    return 'Parked-lane handback sequencing visibility pending / deferred handback still needs owner';

                case 'Future':
                    return 'Parked-lane handback sequencing visibility parked / future handback owner still open';

                case 'Unscheduled':
                    return 'Parked-lane handback sequencing visibility open / owner and handback slot both still unset';
            }

            return 'Parked-lane handback sequencing visibility pending / handback owner still missing';
        }

        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Parked-lane handback sequencing visibility resolved / overdue handback leads now';

            case 'Due today':
                return 'Parked-lane handback sequencing visibility resolved / same-shift handback already sequenced';

            case 'Due soon':
                return 'Parked-lane handback sequencing visibility aligned / next-shift handback sequence visible';

            case 'Near-term':
                return 'Parked-lane handback sequencing visibility aligned / deferred handback sequence preserved';

            case 'Future':
                return 'Parked-lane handback sequencing visibility parked / future handback sequence held';

            case 'Unscheduled':
                return 'Parked-lane handback sequencing visibility partial / owner visible but handback slot still open';
        }

        return 'Parked-lane handback sequencing visibility aligned / handback order readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Parked-lane handback sequencing visibility deferred / active execution still ahead';

        case 'Ready for finish packet':
            return 'Parked-lane handback sequencing visibility deferred / finish drafting still ahead';

        case 'Closure packet prepared':
            return $ownerMissing
                ? 'Parked-lane handback sequencing visibility deferred / decision handback owner missing'
                : 'Parked-lane handback sequencing visibility deferred / decision handback lead visible';

        case 'Prepared but not yet executed':
            return $ownerMissing
                ? 'Parked-lane handback sequencing visibility deferred / prepared follow-through owner missing'
                : 'Parked-lane handback sequencing visibility deferred / prepared handback lead readable';

        case 'Timed for later finish':
            return $ownerMissing
                ? 'Parked-lane handback sequencing visibility queued / timed handback owner still open'
                : 'Parked-lane handback sequencing visibility preserved / timed handback sequence readable';
    }

    return $ownerMissing
        ? 'Parked-lane handback sequencing visibility open / owner and sequence still forming'
        : 'Parked-lane handback sequencing visibility conservative / owner visible while sequence stays light';
}

public function getNearFrontQuietReturnReviewSlotCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Near-front quiet-return review-slot compression collapsed / reopened now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Near-front quiet-return review-slot compression resolved / overdue return already compresses near front';

            case 'Due today':
                return 'Near-front quiet-return review-slot compression resolved / same-shift quiet return already near front';

            case 'Due soon':
                return 'Near-front quiet-return review-slot compression staged / next-shift quiet return compresses into a visible slot';

            case 'Near-term':
                return 'Near-front quiet-return review-slot compression staged / deferred slot preserved without front-loading';

            case 'Future':
                return 'Near-front quiet-return review-slot compression parked / future quiet return stays outside near-front review';

            case 'Unscheduled':
                return 'Near-front quiet-return review-slot compression open / review slot still too light to compress';
        }

        return 'Near-front quiet-return review-slot compression forming / front-slot timing still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Near-front quiet-return review-slot compression deferred / active execution still ahead';

        case 'Ready for finish packet':
            return 'Near-front quiet-return review-slot compression deferred / finish drafting still ahead';

        case 'Closure packet prepared':
            return 'Near-front quiet-return review-slot compression deferred / decision lane still ahead of quiet return';

        case 'Prepared but not yet executed':
            return 'Near-front quiet-return review-slot compression deferred / prepared work not yet parked into review';

        case 'Timed for later finish':
            return 'Near-front quiet-return review-slot compression parked / timed finish stays in a later slot';
    }

    return 'Near-front quiet-return review-slot compression conservative / review-slot posture still forming';
}

public function getParkedLaneHandbackSequencingVisibilityDigestAttribute(): string
{
    return $this->formatSummary([
        'Parked-lane handback sequencing visibility' => $this->parked_lane_handback_sequencing_visibility_label,
        'Near-front quiet-return review-slot compression' => $this->near_front_quiet_return_review_slot_compression_label,
        'Handback' => $this->finish_lane_handback_label,
        'Shift handoff' => $this->same_shift_handoff_sequence_label,
        'Owner reassignment' => $this->parked_lane_owner_reassignment_visibility_label,
        'Deferred slot alignment' => $this->owner_visible_deferred_review_slot_alignment_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Parked-lane handback sequencing visibility digest is still minimal.');
}

public function getNearFrontQuietReturnReviewSlotCompressionFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Parked-lane handback sequencing visibility: ' . $this->parked_lane_handback_sequencing_visibility_label . '.';
    $lines[] = 'Near-front quiet-return review-slot compression: ' . $this->near_front_quiet_return_review_slot_compression_label . '.';
    $lines[] = 'Handback: ' . $this->finish_lane_handback_label . '.';
    $lines[] = 'Shift handoff: ' . $this->same_shift_handoff_sequence_label . '.';
    $lines[] = 'Owner reassignment: ' . $this->parked_lane_owner_reassignment_visibility_label . '.';
    $lines[] = 'Front-of-list quiet return: ' . $this->front_of_list_quiet_return_confirmation_label . '.';
    $lines[] = 'Deferred slot alignment: ' . $this->owner_visible_deferred_review_slot_alignment_label . '.';
    $lines[] = 'Quiet-return shift split: ' . $this->current_shift_next_shift_quiet_return_separation_label . '.';
    $lines[] = 'Review slot: ' . $this->quiet_lane_review_slot_label . '.';
    $lines[] = 'Review-slot compression: ' . $this->review_slot_compression_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, parked-lane handback sequencing should collapse into one immediate human review path. Near-front quiet-return compression therefore reads as resolved now rather than pretending the record still belongs in a deferred parked handback.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the record no longer belongs in a soft parked sequence. Handback sequencing visibility keeps the overdue return attached to one readable owner and handback order, while near-front review-slot compression makes it explicit that the quiet return now belongs near the front of human review.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked review window lands today, the handback should stay same-shift and easy to follow. The handback-sequencing cue keeps owner order and transfer posture readable, while near-front review-slot compression shows that the quiet return should occupy a believable near-front slot instead of drifting back into generic parking.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked review window is close but not yet same-shift urgent, the workspace can keep the handback sequence visible without overstating immediacy. Near-front review-slot compression keeps the next-slot quiet return readable early, while preserving enough distance so current-shift work still stays ahead.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is deferred rather than immediate, the workspace should preserve the handback order without flattening it into front-of-queue urgency. Near-front review-slot compression therefore stays staged, showing a believable upcoming slot without pretending the record already belongs at the top of the queue.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet return is still future-facing, the record can remain parked. Handback sequencing visibility simply preserves who should receive that later handback and in what order, while near-front review-slot compression stays intentionally off so future work does not displace current or next-shift review.';
        } else {
            $lines[] = 'Because the parked lane still lacks usable timing, neither handback sequencing visibility nor near-front review-slot compression can settle honestly yet. The next safe move is to name the owner and assign a credible review slot so the quiet return can move from vague parking into a believable handback sequence.';
        }
    } elseif ($this->closure_readiness_label === 'Execution still open') {
        $lines[] = 'Because close-side execution is still active, the record should stay ahead of parked-lane handback sequencing for now. Near-front quiet-return compression remains deferred until the active work either closes cleanly or is deliberately parked into a review slot.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for finish drafting, the workspace should keep drafting ahead of any parked-lane handback story. The near-front slot should only compress after the operator deliberately decides whether the record returns to review now or later.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a finish-choice packet is already prepared, the record belongs in a near-front decision lane rather than a settled parked return. Handback sequencing visibility simply keeps the eventual lead readable, and near-front review-slot compression waits until the operator decides whether that quiet return truly belongs near the front.';
    } elseif ($this->closure_readiness_label === 'Prepared but not yet executed') {
        $lines[] = 'Because prepared work still needs a deliberate operator move, the workspace should keep the prepared action ahead of passive parked review. Handback sequencing and near-front review-slot compression remain narrow reading aids only until the prepared work is either resumed now or consciously parked.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because finish timing is intentionally deferred, the record can remain parked without pretending it belongs near the front. Handback sequencing visibility simply preserves the later return order, while near-front review-slot compression stays intentionally light.';
    } else {
        $lines[] = 'Because the loyalty workspace stays conservative and human-led, parked-lane handback sequencing visibility and near-front quiet-return review-slot compression remain narrow scan aids only. They reduce translation between handback order, owner visibility, and near-front review-slot placement without widening the workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getOwnerHeldNextShiftHandbackConfirmationLabelAttribute(): string
{
    $ownerMissing = trim((string) $this->owner_name) === '';

    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Owner-held next-shift handback confirmation collapsed / reopened now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if ($ownerMissing) {
            switch ($this->next_review_window_label) {
                case 'Overdue':
                    return 'Owner-held next-shift handback confirmation blocked / overdue return still unowned';

                case 'Due today':
                    return 'Owner-held next-shift handback confirmation blocked / same-shift handback still unowned';

                case 'Due soon':
                    return 'Owner-held next-shift handback confirmation pending / next-shift handback owner still missing';

                case 'Near-term':
                    return 'Owner-held next-shift handback confirmation pending / deferred-lane handback owner still missing';

                case 'Future':
                    return 'Owner-held next-shift handback confirmation parked / future handback owner still open';

                case 'Unscheduled':
                    return 'Owner-held next-shift handback confirmation open / owner and next-shift handback still unset';
            }

            return 'Owner-held next-shift handback confirmation pending / handback owner still missing';
        }

        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Owner-held next-shift handback confirmation resolved / overdue handback no longer belongs next shift';

            case 'Due today':
                return 'Owner-held next-shift handback confirmation resolved / same-shift handback already confirmed';

            case 'Due soon':
                return 'Owner-held next-shift handback confirmation aligned / next-shift handback owner confirmed';

            case 'Near-term':
                return 'Owner-held next-shift handback confirmation staged / deferred-lane handback owner confirmed';

            case 'Future':
                return 'Owner-held next-shift handback confirmation parked / future handback owner confirmed early';

            case 'Unscheduled':
                return 'Owner-held next-shift handback confirmation open / owner visible but next-shift timing still unclear';
        }

        return 'Owner-held next-shift handback confirmation forming / owner-led handback timing still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return $ownerMissing
                ? 'Owner-held next-shift handback confirmation deferred / active execution still unowned'
                : 'Owner-held next-shift handback confirmation deferred / active execution lead already named';

        case 'Ready for finish packet':
            return $ownerMissing
                ? 'Owner-held next-shift handback confirmation deferred / finish drafting owner missing'
                : 'Owner-held next-shift handback confirmation deferred / finish drafting lead already named';

        case 'Closure packet prepared':
            return $ownerMissing
                ? 'Owner-held next-shift handback confirmation deferred / finish-choice owner missing'
                : 'Owner-held next-shift handback confirmation deferred / finish-choice lead already named';

        case 'Prepared but not yet executed':
            return $ownerMissing
                ? 'Owner-held next-shift handback confirmation deferred / prepared follow-through owner missing'
                : 'Owner-held next-shift handback confirmation deferred / prepared lead already named';

        case 'Timed for later finish':
            return $ownerMissing
                ? 'Owner-held next-shift handback confirmation parked / timed finish owner still open'
                : 'Owner-held next-shift handback confirmation preserved / timed finish handback owner readable';
    }

    return $ownerMissing
        ? 'Owner-held next-shift handback confirmation open / owner and timing still forming'
        : 'Owner-held next-shift handback confirmation conservative / owner visible while next-shift confirmation stays light';
}

public function getCurrentLaneDeferredLaneReturnCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Current-lane versus deferred-lane return compression resolved / reopened now';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today', 'Due soon'], true)) {
        return 'Current-lane versus deferred-lane return compression blocked / assign owner before lane compression';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Current-lane versus deferred-lane return compression resolved / overdue return belongs in the current lane now';

            case 'Due today':
                return 'Current-lane versus deferred-lane return compression resolved / same-shift return stays in the current lane';

            case 'Due soon':
                return 'Current-lane versus deferred-lane return compression staged / next-shift return compressed without entering the current lane';

            case 'Near-term':
                return 'Current-lane versus deferred-lane return compression staged / deferred lane preserved outside the current lane';

            case 'Future':
                return 'Current-lane versus deferred-lane return compression parked / future return stays in the deferred lane';

            case 'Unscheduled':
                return 'Current-lane versus deferred-lane return compression open / lane split unclear until timing is set';
        }

        return 'Current-lane versus deferred-lane return compression forming / parked timing still stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Execution still open':
            return 'Current-lane versus deferred-lane return compression deferred / active execution still ahead';

        case 'Ready for finish packet':
            return 'Current-lane versus deferred-lane return compression deferred / finish drafting first';

        case 'Closure packet prepared':
            return 'Current-lane versus deferred-lane return compression deferred / finish-choice lane first';

        case 'Prepared but not yet executed':
            return 'Current-lane versus deferred-lane return compression deferred / prepared follow-through first';

        case 'Timed for later finish':
            return 'Current-lane versus deferred-lane return compression parked / later finish window preserved';
    }

    return 'Current-lane versus deferred-lane return compression conservative / lane split still forming';
}

public function getOwnerHeldNextShiftHandbackConfirmationDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-held next-shift handback confirmation' => $this->owner_held_next_shift_handback_confirmation_label,
        'Current-lane versus deferred-lane return compression' => $this->current_lane_deferred_lane_return_compression_label,
        'Handback sequence' => $this->parked_lane_handback_sequencing_visibility_label,
        'Near-front slot' => $this->near_front_quiet_return_review_slot_compression_label,
        'Deferred slot alignment' => $this->owner_visible_deferred_review_slot_alignment_label,
        'Quiet-return shift split' => $this->current_shift_next_shift_quiet_return_separation_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Owner-held next-shift handback confirmation digest is still minimal.');
}

public function getCurrentLaneDeferredLaneReturnCompressionFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-held next-shift handback confirmation: ' . $this->owner_held_next_shift_handback_confirmation_label . '.';
    $lines[] = 'Current-lane versus deferred-lane return compression: ' . $this->current_lane_deferred_lane_return_compression_label . '.';
    $lines[] = 'Handback sequence: ' . $this->parked_lane_handback_sequencing_visibility_label . '.';
    $lines[] = 'Near-front slot: ' . $this->near_front_quiet_return_review_slot_compression_label . '.';
    $lines[] = 'Deferred slot alignment: ' . $this->owner_visible_deferred_review_slot_alignment_label . '.';
    $lines[] = 'Quiet-return shift split: ' . $this->current_shift_next_shift_quiet_return_separation_label . '.';
    $lines[] = 'Queue separation: ' . $this->front_of_queue_parked_lane_separation_label . '.';
    $lines[] = 'Front-of-list quiet return: ' . $this->front_of_list_quiet_return_confirmation_label . '.';
    $lines[] = 'Owner-state handoff: ' . $this->owner_state_handoff_compression_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, any next-shift handback story should collapse into one current human review path. Owner-held next-shift handback confirmation therefore reads as resolved now, and current-lane versus deferred-lane return compression should stop pretending the record still belongs in a quiet parked lane.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today', 'Due soon'], true)) {
        $lines[] = 'Because the record has already entered an urgent or near-urgent review window but still has no named owner, the workspace should not compress it cleanly into either a current lane or a next-shift deferred lane. The first safe move is to assign the operator so handback confirmation and lane compression become believable together across the list, overview workspace, and linked inquiry snapshot.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the record no longer belongs in a deferred-lane story. Owner-held next-shift handback confirmation simply shows that any prior handback assumption has collapsed, while current-lane versus deferred-lane compression makes it explicit that the return belongs in the current human review lane now.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked review window lands today, the record belongs in a same-shift current lane rather than a next-shift handback. The owner-held handback cue confirms who should carry the return now, and lane compression makes it obvious that this quiet return should not drift back into a deferred parked lane.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked review window is close but not yet same-shift urgent, the workspace can keep the handback owner visible while still treating the return as next-shift work. Current-lane versus deferred-lane compression keeps that return compressed into a believable next slot without overstating it as immediate current-lane work.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is deferred rather than next-shift imminent, the workspace should preserve the owner-held handback without flattening it into current-lane urgency. Lane compression therefore stays staged, showing that the return belongs in a deferred lane but still remains readable as an approaching human review handback.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet return is still future-facing, the record can remain parked. Owner-held next-shift handback confirmation simply preserves who should receive the later handback, while current-lane versus deferred-lane compression keeps future work from displacing current-lane or next-shift review.';
        } else {
            $lines[] = 'Because the parked lane still lacks usable timing, neither owner-held next-shift handback confirmation nor current-lane versus deferred-lane compression can settle honestly yet. The next safe move is to name the owner and assign a credible review slot so the workspace can compress the return without guesswork.';
        }
    } elseif ($this->closure_readiness_label === 'Execution still open') {
        $lines[] = 'Because close-side execution is still active, the record should stay ahead of parked return compression for now. The owner-held next-shift handback cue simply confirms whether a lead is already visible, and the lane-compression cue stays deferred until the execution story closes or parks.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for finish drafting, the workspace should keep drafting ahead of any next-shift handback story. Lane compression therefore stays conservative until the drafting decision resolves into either current-lane work or a genuinely deferred parked return.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a finish-choice packet is already prepared, the record belongs in a near-front decision lane rather than a settled next-shift handback. Owner-held confirmation keeps the likely lead explicit, and current-lane versus deferred-lane compression waits until the operator deliberately decides where the return truly belongs.';
    } elseif ($this->closure_readiness_label === 'Prepared but not yet executed') {
        $lines[] = 'Because prepared work still needs a deliberate operator move, the record should stay ahead of passive lane compression. Owner-held handback confirmation and current-versus-deferred lane compression remain narrow reading aids only until the prepared work is either resumed now or consciously parked.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because finish timing is intentionally deferred, the record can remain parked without pretending it belongs in the current lane. Owner-held next-shift handback confirmation simply preserves who should receive the later return, and lane compression keeps that later quiet move distinct from active current-lane work.';
    } else {
        $lines[] = 'Because the loyalty workspace stays conservative and human-led, owner-held next-shift handback confirmation and current-lane versus deferred-lane return compression remain narrow scan aids only. They reduce translation between ownership, lane placement, and quiet-return timing without widening the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getQueueWatchReadinessLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopened lane / immediate human review';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked watch due now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Parked watch due soon';
        }

        return 'Parked watch stable';
    }

    if ($this->latest_closure_packet_mode !== '') {
        return 'Closure packet prepared / lane not parked';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Continuity review due now';
    }

    if ($this->next_review_window_label === 'Due soon') {
        return 'Continuity review due soon';
    }

    return 'Quiet continuity watch';
}

public function getDeliberateReopenPriorityLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Immediate';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'High';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Medium';
        }

        return 'Low';
    }

    if ($this->latest_closure_packet_mode !== '') {
        return 'Medium';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'High';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Medium';
    }

    return 'Low';
}

public function getQueueWatchDigestAttribute(): string
{
    return $this->formatSummary([
        'Queue watch readiness' => $this->queue_watch_readiness_label,
        'Reopen priority' => $this->deliberate_reopen_priority_label,
        'Queue band' => $this->queue_compression_band_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Reopen trigger' => $this->parked_lane_reopen_trigger_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')' : 'Not scheduled',
        'List scan aid' => $this->list_scan_aid_label,
    ], 'Queue watch digest is still minimal.');
}

public function getReopenPriorityFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Queue watch readiness: ' . $this->queue_watch_readiness_label . '.';
    $lines[] = 'Deliberate reopen priority: ' . $this->deliberate_reopen_priority_label . '.';
    $lines[] = 'Queue band: ' . $this->queue_compression_band_label . '.';
    $lines[] = 'Parked watch: ' . $this->parked_lane_watch_label . '.';
    $lines[] = 'Reopen trigger: ' . rtrim($this->parked_lane_reopen_trigger_label, '.') . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is reopened already, the record should sit at the top of deliberate human review until the new proof is interpreted and the lane is either re-parked or advanced.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the lane is parked but the watch window is due now, this record should surface early in queue review even though the finish posture remains formally parked.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the lane is parked and the review window is approaching, this record deserves medium-priority human attention before the parked watch quietly drifts overdue.';
        } else {
            $lines[] = 'Because the lane is parked and the watch window is stable, the record can stay quiet until the next review window or reopen trigger justifies a deliberate move.';
        }
    } elseif ($this->latest_closure_packet_mode !== '') {
        $lines[] = 'Because a closure packet already exists but the finish lane is not parked yet, this record should not be buried; the next deliberate move is to park the matching lane or reopen it with clear proof.';
    } else {
        $lines[] = 'Because no parked finish lane exists yet, this record should stay in conservative continuity review rather than being treated like an automated reopen candidate.';
    }

    return implode(PHP_EOL, $lines);
}


public function getFinishWatchSignalLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopen review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked watch due now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Parked watch due soon';
        }

        return 'Parked and quiet';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Prepare finish packet';

        case 'Closure packet prepared':
            return 'Park finish lane';

        case 'Execution still open':
            return 'Finish follow-through open';

        case 'Prepared but not yet executed':
            return 'Prepared / not started';

        case 'Timed for later finish':
            return 'Timed finish watch';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Continuity review due';
    }

    if ($this->next_review_window_label === 'Due soon') {
        return 'Continuity review due soon';
    }

    return 'Quiet continuity review';
}

public function getReopenQueueCueLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Interpret fresh proof';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Review parked lane now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Check before due';
        }

        return 'Hold parked watch';
    }

    if ($this->latest_closure_packet_mode !== '') {
        return 'Park or reopen deliberately';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Draft closure packet';

        case 'Closure packet prepared':
            return 'Choose finish lane';

        case 'Execution still open':
            return 'Finish follow-through';

        case 'Prepared but not yet executed':
            return 'Start prepared packet';

        case 'Timed for later finish':
            return 'Hold for review window';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return trim((string) $this->owner_name) === ''
            ? 'Assign and review now'
            : 'Review continuity now';
    }

    return 'Keep conservative review';
}

public function getFinishWatchDashboardDigestAttribute(): string
{
    return $this->formatSummary([
        'Finish watch' => $this->finish_watch_signal_label,
        'Reopen queue cue' => $this->reopen_queue_cue_label,
        'Finish dashboard' => $this->finish_dashboard_status_label,
        'Queue watch' => $this->queue_watch_readiness_label,
        'Reopen priority' => $this->deliberate_reopen_priority_label,
        'Finish triage' => $this->finish_triage_label,
        'Triage urgency' => $this->finish_triage_urgency_label,
        'Queue band' => $this->queue_compression_band_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next finish move' => $this->next_finish_move_label,
        'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')' : 'Not scheduled',
    ], 'Finish-watch dashboard digest is still minimal.');
}

public function getReopenQueueCueFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Finish watch signal: ' . $this->finish_watch_signal_label . '.';
    $lines[] = 'Reopen queue cue: ' . $this->reopen_queue_cue_label . '.';
    $lines[] = 'Finish dashboard: ' . $this->finish_dashboard_status_label . '.';
    $lines[] = 'Queue watch readiness: ' . $this->queue_watch_readiness_label . '.';
    $lines[] = 'Deliberate reopen priority: ' . $this->deliberate_reopen_priority_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';
    $lines[] = 'Next finish move: ' . $this->next_finish_move_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is already reopened, the narrowest queue cue is to interpret the fresh proof now and decide whether the record advances, closes, or gets deliberately re-parked.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the lane is parked but the watch window is due now, the record should rise early in review even though the finish posture remains formally parked.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the lane is parked and the watch window is approaching, the right cue is to review the lane before the parked watch quietly turns urgent.';
        } else {
            $lines[] = 'Because the parked watch is stable, the right cue is to hold the lane quietly until the next review window or a clear reopen trigger appears.';
        }
    } elseif ($this->latest_closure_packet_mode !== '') {
        $lines[] = 'Because a closure packet already exists but no parked lane is explicit yet, the right cue is to choose the finish lane deliberately instead of letting the record drift in general review.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because finish posture is ready, the right cue is to draft the narrow finish packet and keep the record out of a broad open-ended review loop.';
    } elseif (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the continuity review window is already due, the record should surface for human review now even though it is not yet a formal reopen case.';
    } else {
        $lines[] = 'Because finish posture is still conservative, the record can stay in a quiet human-owned queue until the next review window or stronger proof arrives.';
    }

    return implode(PHP_EOL, $lines);
}

    public function getFinishCloseCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopened / close decision pending';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked / close review due now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Parked / close review due soon';
        }

        return 'Parked / close watch stable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Close packet should be drafted';

        case 'Closure packet prepared':
            return 'Close packet ready / choose lane';

        case 'Execution still open':
            return 'Close follow-through still open';

        case 'Prepared but not yet executed':
            return 'Close packet prepared / not started';

        case 'Timed for later finish':
            return 'Close timing deferred';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Close review due now';
    }

    if ($this->next_review_window_label === 'Due soon') {
        return 'Close review due soon';
    }

    return 'Close posture still forming';
}

public function getReopenScanOrderLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · reopened lane / read first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return '02 · parked watch due now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return '07 · parked watch due soon';
        }

        return '09 · parked watch stable';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '03 · unassigned due review';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '04 · finish packet queue';

        case 'Closure packet prepared':
            return '05 · choose finish lane';

        case 'Execution still open':
        case 'Prepared but not yet executed':
            return '06 · finish follow-through';

        case 'Timed for later finish':
            return '10 · timed finish watch';
    }

    if ($this->next_review_window_label === 'Due soon') {
        return '08 · review due soon';
    }

    return '11 · quiet review hold';
}

public function getFinishCloseDashboardDigestAttribute(): string
{
    return $this->formatSummary([
        'Finish-close signal' => $this->finish_close_compression_label,
        'Reopen scan order' => $this->reopen_scan_order_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Finish dashboard' => $this->finish_dashboard_status_label,
        'Finish watch' => $this->finish_watch_signal_label,
        'Reopen cue' => $this->reopen_queue_cue_label,
        'Next finish move' => $this->next_finish_move_label,
        'Latest closure packet' => $this->latest_closure_packet_label,
        'Parked watch' => $this->parked_lane_watch_label,
        'Next review' => $this->next_review_at ? $this->next_review_at->format('Y-m-d H:i') . ' (' . $this->next_review_window_label . ')' : 'Not scheduled',
    ], 'Finish-close dashboard digest is still minimal.');
}

public function getReopenScanOrderFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Finish-close signal: ' . $this->finish_close_compression_label . '.';
    $lines[] = 'Reopen scan order: ' . $this->reopen_scan_order_label . '.';
    $lines[] = 'Closure readiness: ' . $this->closure_readiness_label . '.';
    $lines[] = 'Finish watch: ' . $this->finish_watch_signal_label . '.';
    $lines[] = 'Reopen cue: ' . $this->reopen_queue_cue_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is already reopened, this record should sit first in deliberate human review until the new proof is interpreted and a clear close or re-park decision is made.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the finish lane is parked but the watch window is due now, this record should rise near the top of the queue even though the finish posture remains formally parked.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the finish lane is parked and the watch window is approaching, this record should be scanned ahead of quiet parked holds before the watch turns urgent.';
        } else {
            $lines[] = 'Because the parked finish watch is stable, this record can stay lower in the queue until the review window or reopen trigger changes the close posture.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because close posture is ready, this record should sit ahead of quiet review so the narrow finish packet is drafted instead of the lane drifting.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet already exists, the next queue move is to choose the finish lane deliberately rather than leaving the record ambiguous between close and reopen.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close follow-through is still open, this record belongs in active human follow-through ahead of quiet watch lanes.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because review timing is already due and ownership is missing, this record should rise early in the queue until a human owner is explicit.';
    } else {
        $lines[] = 'Because close posture is still conservative, this record can stay in a lower quiet-review position until stronger proof or timing makes a deliberate move necessary.';
    }

    return implode(PHP_EOL, $lines);
}


public function getCloseHandoffGroupLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Reopened handoff / immediate review';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Parked handoff / due-now watch';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Parked handoff / due-soon watch';
        }

        return 'Parked handoff / quiet watch';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Ownership handoff / assign first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Pre-close handoff / packet drafting';

        case 'Closure packet prepared':
            return 'Close handoff / lane choice';

        case 'Execution still open':
        case 'Prepared but not yet executed':
            return 'Execution handoff / follow-through';

        case 'Timed for later finish':
            return 'Timed handoff / later finish review';
    }

    return 'Review handoff / quiet hold';
}

public function getFinishReviewExitLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Exit parked close and review new proof now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Exit quiet watch and check the parked lane now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Schedule the parked close review before due';
        }

        return 'Stay parked until trigger or watch window changes';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Assign an owner before finish review can exit cleanly';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Draft the finish packet and narrow the exit path';

        case 'Closure packet prepared':
            return 'Choose finish lane and log the close decision';

        case 'Execution still open':
            return 'Complete follow-through before any finish exit';

        case 'Prepared but not yet executed':
            return 'Start prepared follow-through before close exit';

        case 'Timed for later finish':
            return 'Hold timed finish review until the next window';
    }

    return 'Keep the record in conservative finish review';
}

public function getCloseHandoffDigestAttribute(): string
{
    return $this->formatSummary([
        'Close handoff group' => $this->close_handoff_group_label,
        'Finish review exit' => $this->finish_review_exit_label,
        'Finish-close signal' => $this->finish_close_compression_label,
        'Reopen scan order' => $this->reopen_scan_order_label,
        'Closure readiness' => $this->closure_readiness_label,
        'Finish watch' => $this->finish_watch_signal_label,
        'Reopen cue' => $this->reopen_queue_cue_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next finish move' => $this->next_finish_move_label,
    ], 'Close handoff digest is still minimal.');
}

public function getFinishReviewExitFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Close handoff group: ' . $this->close_handoff_group_label . '.';
    $lines[] = 'Finish review exit: ' . $this->finish_review_exit_label . '.';
    $lines[] = 'Finish-close signal: ' . $this->finish_close_compression_label . '.';
    $lines[] = 'Reopen scan order: ' . $this->reopen_scan_order_label . '.';
    $lines[] = 'Closure readiness: ' . $this->closure_readiness_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, the clean exit from finish review is to interpret the new proof now and either re-park deliberately or move the record into the next explicit close decision.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the record is parked but the watch is due now, the next clean exit is a deliberate parked-lane review instead of leaving the close posture silent.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked watch is approaching, the clean exit is to schedule the review before due so the record does not drift into urgent reopen work.';
        } else {
            $lines[] = 'Because the parked close watch is stable, the clean exit is to hold the lane quietly until a trigger or timing change justifies reopening it.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because ownership is missing while review timing is already due, the clean exit is to assign a human owner before any finish decision is treated as settled.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close work, the clean exit is to draft the narrow finish packet now so the review can move out of ambiguity.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a finish packet already exists, the clean exit is to choose the correct finish lane and log that close decision explicitly.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because finish follow-through is still active, the clean exit is to complete the prepared work before treating the record as closed or quietly parked.';
    } else {
        $lines[] = 'Because finish posture is still conservative, the clean exit is to keep the record in deliberate human review until stronger proof or timing changes the close path.';
    }

    return implode(PHP_EOL, $lines);
}


public function getFinishLaneHandbackLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Hand back to active review owner now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Hand back to owner for parked review now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Hand back to owner before parked review is due';
        }

        return 'Hand back to timed watch owner';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Hand back to assignment before close review';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Hand back to close drafter';

        case 'Closure packet prepared':
            return 'Hand back to finish-lane chooser';

        case 'Execution still open':
        case 'Prepared but not yet executed':
            return 'Hand back to follow-through owner';

        case 'Timed for later finish':
            return 'Hand back to timed finish hold';
    }

    return 'Hand back to quiet review owner';
}

public function getPostCloseHoldLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Do not hold closed / active proof review';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Post-close hold due now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Post-close hold due soon';
        }

        return 'Quiet post-close hold';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Unsafe hold / assign owner first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Hold close until packet is drafted';

        case 'Closure packet prepared':
            return 'Hold close until lane is chosen';

        case 'Execution still open':
            return 'Hold close until follow-through completes';

        case 'Prepared but not yet executed':
            return 'Hold close until prepared work starts';

        case 'Timed for later finish':
            return 'Timed post-close hold';
    }

    return 'Conservative post-close hold';
}

public function getFinishHandbackDigestAttribute(): string
{
    return $this->formatSummary([
        'Finish-lane handback' => $this->finish_lane_handback_label,
        'Post-close hold' => $this->post_close_hold_label,
        'Close handoff group' => $this->close_handoff_group_label,
        'Finish review exit' => $this->finish_review_exit_label,
        'Finish-close signal' => $this->finish_close_compression_label,
        'Reopen scan order' => $this->reopen_scan_order_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next finish move' => $this->next_finish_move_label,
    ], 'Finish handback digest is still minimal.');
}

public function getPostCloseHoldFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Finish-lane handback: ' . $this->finish_lane_handback_label . '.';
    $lines[] = 'Post-close hold: ' . $this->post_close_hold_label . '.';
    $lines[] = 'Close handoff group: ' . $this->close_handoff_group_label . '.';
    $lines[] = 'Finish review exit: ' . $this->finish_review_exit_label . '.';
    $lines[] = 'Finish-close signal: ' . $this->finish_close_compression_label . '.';
    $lines[] = 'Reopen scan order: ' . $this->reopen_scan_order_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is already reopened, the record should not sit in any quiet close hold. The clean handback is active human review now so the new proof can be interpreted and the lane can be deliberately closed again or re-parked.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the record is parked but the watch window is due now, the correct handback is to the owner for immediate parked-lane review instead of letting the close hold stay silent.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked watch is approaching, the record can remain in a temporary close hold only until the owner confirms the review before the due window arrives.';
        } else {
            $lines[] = 'Because the parked finish watch is stable, the close hold can stay quiet and human-owned until a trigger or review window change makes a more active handback necessary.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because review timing is already due and ownership is missing, the record should not rest in a quiet post-close hold. The clean handback is to assign an owner first.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because close posture is ready but not yet packeted, the record should stay in a narrow hold only long enough for the close drafter to prepare the finish packet.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet already exists, the handback is to the operator choosing the finish lane. The post-close hold should remain temporary until that lane choice is explicit.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close follow-through is still active, the record can stay in a temporary close hold only while the assigned human completes the prepared work.';
    } else {
        $lines[] = 'Because finish posture is still conservative, the record can remain in a quiet post-close hold under human review until stronger proof or timing changes the lane.';
    }

    return implode(PHP_EOL, $lines);
}


public function getHoldReleaseCueLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Release quiet hold / active proof review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Release quiet hold for parked review now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Release quiet hold before parked review is due';
        }

        return 'Keep quiet hold until the watch changes';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Release hold for assignment first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Release hold when packet drafting starts';

        case 'Closure packet prepared':
            return 'Release hold when the finish lane is chosen';

        case 'Execution still open':
            return 'Release hold when follow-through resumes';

        case 'Prepared but not yet executed':
            return 'Release hold when prepared work begins';

        case 'Timed for later finish':
            return 'Release hold at the timed finish window';
    }

    return 'Keep hold under quiet human review';
}

public function getQuietLaneReturnLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return to active review lane';
    }

    if ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            return 'Return to parked review owner now';
        }

        if ($this->next_review_window_label === 'Due soon') {
            return 'Return to parked review owner before due';
        }

        return 'Return to timed quiet lane';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return to assignment lane first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return to close drafting lane';

        case 'Closure packet prepared':
            return 'Return to finish-lane choice';

        case 'Execution still open':
            return 'Return to follow-through lane';

        case 'Prepared but not yet executed':
            return 'Return to prepared execution lane';

        case 'Timed for later finish':
            return 'Return to timed finish lane';
    }

    return 'Return to quiet review lane';
}

public function getHoldReleaseDigestAttribute(): string
{
    return $this->formatSummary([
        'Hold release cue' => $this->hold_release_cue_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Finish-lane handback' => $this->finish_lane_handback_label,
        'Post-close hold' => $this->post_close_hold_label,
        'Close handoff group' => $this->close_handoff_group_label,
        'Finish review exit' => $this->finish_review_exit_label,
        'Reopen scan order' => $this->reopen_scan_order_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next finish move' => $this->next_finish_move_label,
    ], 'Hold-release digest is still minimal.');
}

public function getQuietLaneReturnFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';
    $lines[] = 'Quiet-lane return: ' . $this->quiet_lane_return_label . '.';
    $lines[] = 'Finish-lane handback: ' . $this->finish_lane_handback_label . '.';
    $lines[] = 'Post-close hold: ' . $this->post_close_hold_label . '.';
    $lines[] = 'Close handoff group: ' . $this->close_handoff_group_label . '.';
    $lines[] = 'Finish review exit: ' . $this->finish_review_exit_label . '.';
    $lines[] = 'Reopen scan order: ' . $this->reopen_scan_order_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, the quiet close hold should be released now and the lane should return to active human review instead of resting in a silent close posture.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the parked watch is due now, any quiet hold should end immediately and the lane should return to the parked review owner for deliberate review.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked watch is approaching, the quiet hold can remain temporary only until the owner confirms the next review before the due window arrives.';
        } else {
            $lines[] = 'Because the parked lane is still stable, the quiet hold can remain human-owned and the lane can return to the timed watch posture until proof or timing changes.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because review timing is already due and ownership is missing, the hold should be released for assignment first so the lane has an explicit human return path.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the close posture is ready but not yet packeted, the quiet hold should end when drafting begins and the lane should return to the close drafter.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet already exists, the quiet hold should end when the finish lane is chosen and the lane should return to that explicit close decision.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close follow-through still needs human action, the quiet hold should only remain temporary and the lane should return to the operator completing that work.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because the finish lane is intentionally timed for later, the quiet hold can stay in place until the timing window arrives and the lane returns to the timed finish review.';
    } else {
        $lines[] = 'Because finish posture is still conservative, the quiet hold can remain in place under human ownership until clearer proof, ownership, or timing creates a stronger return path.';
    }

    return implode(PHP_EOL, $lines);
}

public function getHoldAgingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Quiet hold inactive / reopened now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
            case 'Due today':
                return 'Quiet hold aged out / review now';

            case 'Due soon':
                return 'Quiet hold maturing / review soon';

            case 'Near-term':
                return 'Quiet hold stable / near-term watch';

            case 'Future':
                return 'Fresh quiet hold / future watch';

            case 'Unscheduled':
                return 'Quiet hold parked / schedule missing';
        }

        return 'Quiet hold parked / timing still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Hold aging unsafe / owner missing';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Temporary hold / packet drafting window';

        case 'Closure packet prepared':
            return 'Temporary hold / lane choice pending';

        case 'Execution still open':
            return 'Temporary hold / follow-through aging';

        case 'Prepared but not yet executed':
            return 'Temporary hold / prepared work waiting';

        case 'Timed for later finish':
            return 'Timed hold / future finish window';
    }

    return 'Conservative hold / quiet review aging';
}

public function getQuietReturnReviewTimingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Review timing now / active lane';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
            case 'Due today':
                return 'Quiet return timing due now';

            case 'Due soon':
                return 'Quiet return timing due soon';

            case 'Near-term':
                return 'Quiet return timing near-term';

            case 'Future':
                return 'Quiet return timing later';

            case 'Unscheduled':
                return 'Quiet return timing unscheduled';
        }

        return 'Quiet return timing still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Assign timing owner now';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return timing when drafting starts';

        case 'Closure packet prepared':
            return 'Return timing when lane is chosen';

        case 'Execution still open':
            return 'Return timing when follow-through resumes';

        case 'Prepared but not yet executed':
            return 'Return timing when prepared work begins';

        case 'Timed for later finish':
            return 'Return timing at finish window';
    }

    return 'Return timing under quiet review';
}

public function getHoldAgingDigestAttribute(): string
{
    return $this->formatSummary([
        'Hold aging' => $this->hold_aging_label,
        'Quiet-return timing' => $this->quiet_return_review_timing_label,
        'Hold release cue' => $this->hold_release_cue_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Finish-lane handback' => $this->finish_lane_handback_label,
        'Post-close hold' => $this->post_close_hold_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next review window' => $this->next_review_window_label,
        'Next finish move' => $this->next_finish_move_label,
    ], 'Hold-aging digest is still minimal.');
}

public function getQuietReturnReviewTimingFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Hold aging: ' . $this->hold_aging_label . '.';
    $lines[] = 'Quiet-return timing: ' . $this->quiet_return_review_timing_label . '.';
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';
    $lines[] = 'Quiet-lane return: ' . $this->quiet_lane_return_label . '.';
    $lines[] = 'Finish-lane handback: ' . $this->finish_lane_handback_label . '.';
    $lines[] = 'Post-close hold: ' . $this->post_close_hold_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, quiet hold aging is no longer the controlling read. The return timing is now immediate human review so the lane can be deliberately stabilized again.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the parked watch is due now, the quiet hold has effectively aged out. The return timing belongs in immediate human review instead of a silent hold.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked watch is due soon, the quiet hold is entering its mature stage and the return timing should be prepared now so the lane does not drift into urgency.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the parked watch is near-term but not urgent, the quiet hold can remain readable and stable while the operator keeps the next review window visible.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the parked watch sits further out, the quiet hold is still fresh and the return timing can remain later, provided the lane stays human-owned and visible.';
        } else {
            $lines[] = 'Because the quiet hold has no clear review schedule yet, the timing should stay conservative until the next return window is made explicit.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because review timing is already due and ownership is missing, the hold is aging unsafely. The next timing move is to assign a human owner before leaving the record in any quiet posture.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for packet drafting, the quiet hold should stay temporary. The return timing becomes active when the close drafter starts the packet work.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet already exists, the quiet hold should not age indefinitely. The return timing becomes active when the finish lane choice is made explicitly.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs human action, the hold can remain temporary only while the operator keeps the return timing visible and resumes the prepared work deliberately.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because the record is intentionally timed for later finish work, the quiet hold can age conservatively until the scheduled finish window becomes the next active review point.';
    } else {
        $lines[] = 'Because finish posture is still conservative, the quiet hold can remain readable under human ownership while the return timing stays visible as the next decision anchor.';
    }

    return implode(PHP_EOL, $lines);
}



public function getHoldAgingCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'No quiet compression / lane active now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
            case 'Due today':
                return 'Quiet hold expired / re-entry now';

            case 'Due soon':
                return 'Quiet hold compressed / ready soon';

            case 'Near-term':
                return 'Quiet hold compressed / near-term ready';

            case 'Future':
                return 'Quiet hold compressed / later watch';

            case 'Unscheduled':
                return 'Quiet hold compressed / schedule missing';
        }

        return 'Quiet hold compressed / timing forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Compression unsafe / owner missing';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Compressed hold / drafting handoff';

        case 'Closure packet prepared':
            return 'Compressed hold / lane choice pending';

        case 'Execution still open':
            return 'Compressed hold / follow-through pending';

        case 'Prepared but not yet executed':
            return 'Compressed hold / prepared work waiting';

        case 'Timed for later finish':
            return 'Compressed hold / timed finish watch';
    }

    return 'Compressed quiet hold / human review';
}

public function getQuietLaneReentryReadinessLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Re-entry active now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
            case 'Due today':
                return 'Ready for quiet-lane re-entry now';

            case 'Due soon':
                return 'Prepare quiet-lane re-entry';

            case 'Near-term':
                return 'Quiet-lane re-entry nearly ready';

            case 'Future':
                return 'Quiet-lane re-entry deferred';

            case 'Unscheduled':
                return 'Quiet-lane re-entry not yet schedulable';
        }

        return 'Quiet-lane re-entry still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Assign owner before re-entry';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Re-entry ready when drafting begins';

        case 'Closure packet prepared':
            return 'Re-entry ready when lane is chosen';

        case 'Execution still open':
            return 'Re-entry ready when follow-through resumes';

        case 'Prepared but not yet executed':
            return 'Re-entry ready when prepared work starts';

        case 'Timed for later finish':
            return 'Re-entry ready at finish window';
    }

    return 'Re-entry readiness under quiet review';
}

public function getHoldAgingCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Hold-aging compression' => $this->hold_aging_compression_label,
        'Quiet-lane re-entry readiness' => $this->quiet_lane_reentry_readiness_label,
        'Hold aging' => $this->hold_aging_label,
        'Quiet-return timing' => $this->quiet_return_review_timing_label,
        'Hold release cue' => $this->hold_release_cue_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Post-close hold' => $this->post_close_hold_label,
        'Owner timing' => $this->owner_timing_signal_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Hold-aging compression digest is still minimal.');
}

public function getQuietLaneReentryReadinessFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Hold-aging compression: ' . $this->hold_aging_compression_label . '.';
    $lines[] = 'Quiet-lane re-entry readiness: ' . $this->quiet_lane_reentry_readiness_label . '.';
    $lines[] = 'Hold aging: ' . $this->hold_aging_label . '.';
    $lines[] = 'Quiet-return timing: ' . $this->quiet_return_review_timing_label . '.';
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';
    $lines[] = 'Quiet-lane return: ' . $this->quiet_lane_return_label . '.';
    $lines[] = 'Post-close hold: ' . $this->post_close_hold_label . '.';
    $lines[] = 'Owner timing: ' . $this->owner_timing_signal_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, the quiet posture is no longer just aging in place. Re-entry readiness is immediate, and the lane belongs in explicit human review now.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
            $lines[] = 'Because the parked watch is already due, the quiet hold has compressed as far as it can. The lane is ready to re-enter active human review now instead of remaining in a silent hold.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the parked watch is close, the quiet hold can stay narrow only briefly. Re-entry readiness should be treated as active preparation so the owner can review before urgency takes over.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the parked watch is near-term but not urgent, the hold can remain compressed and readable while the operator keeps re-entry readiness visible instead of letting the lane drift.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the parked watch sits further out, the quiet hold can stay compressed and stable. Re-entry readiness can remain deferred, provided ownership and the future review window stay explicit.';
        } else {
            $lines[] = 'Because the quiet hold has no clear schedule yet, the posture can only stay compressed safely if a human makes the re-entry path more explicit soon.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because review timing is already due and ownership is missing, the quiet hold cannot be treated as safely compressed. The lane needs an owner before any re-entry readiness is credible.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, the hold can stay compressed only as a short staging posture. Re-entry readiness becomes active when the drafter begins the finish packet.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet already exists, the hold can stay compressed only while the operator chooses the finish lane deliberately. Re-entry readiness becomes active at that lane-choice point.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs human action, the hold can stay compressed only while the operator keeps the next re-entry point visible and resumes the prepared work deliberately.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because the record is intentionally timed for later finish work, the quiet hold can remain compressed until the timed window becomes the next active human re-entry point.';
    } else {
        $lines[] = 'Because finish posture is still conservative, the quiet hold can remain compressed under human ownership while re-entry readiness stays visible as the next deliberate move.';
    }

    return implode(PHP_EOL, $lines);
}


public function getHoldExpiryGroupLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Expired hold / active review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Expiry breached / reopen now';

            case 'Due today':
                return 'Expiry due now / same-day review';

            case 'Due soon':
                return 'Expiry approaching / prepare re-entry';

            case 'Near-term':
                return 'Mid-window expiry / quiet watch';

            case 'Future':
                return 'Far-window expiry / hold stable';

            case 'Unscheduled':
                return 'Expiry unclear / schedule the hold';
        }

        return 'Hold-expiry grouping still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Expiry due / owner missing';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Draft-stage expiry / handoff soon';

        case 'Closure packet prepared':
            return 'Lane-choice expiry / decide the hold';

        case 'Execution still open':
            return 'Execution-bound expiry / follow-through first';

        case 'Prepared but not yet executed':
            return 'Prepared-work expiry / execution still pending';

        case 'Timed for later finish':
            return 'Timed expiry / later finish window';
    }

    return 'Conservative expiry / human watch';
}

public function getQuietLaneReentryOrderLabelAttribute(): string
{
    $ownerMissing = trim((string) $this->owner_name) === '';

    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · active re-entry now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return $ownerMissing
                    ? '02 · overdue / assign owner and review'
                    : '01 · overdue / reopen first';

            case 'Due today':
                return $ownerMissing
                    ? '03 · due today / assign owner'
                    : '02 · due today / same-day review';

            case 'Due soon':
                return '04 · due soon / prepare review';

            case 'Near-term':
                return '05 · near-term / quiet watch';

            case 'Future':
                return '06 · future / keep compressed';

            case 'Unscheduled':
                return $ownerMissing
                    ? '07 · unscheduled / assign owner and date'
                    : '07 · unscheduled / set review date';
        }

        return '06 · re-entry order still forming';
    }

    if ($ownerMissing && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '03 · due / assign owner first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '04 · drafting / handback next';

        case 'Closure packet prepared':
            return '04 · packet ready / choose lane';

        case 'Execution still open':
            return '05 · execution open / re-entry after follow-through';

        case 'Prepared but not yet executed':
            return '05 · prepared work / start before re-entry';

        case 'Timed for later finish':
            return '06 · timed finish / wait for window';
    }

    return '06 · quiet review / keep in sequence';
}

public function getHoldExpiryGroupingDigestAttribute(): string
{
    return $this->formatSummary([
        'Hold-expiry group' => $this->hold_expiry_group_label,
        'Quiet-lane re-entry order' => $this->quiet_lane_reentry_order_label,
        'Hold-aging compression' => $this->hold_aging_compression_label,
        'Quiet-lane re-entry readiness' => $this->quiet_lane_reentry_readiness_label,
        'Hold aging' => $this->hold_aging_label,
        'Quiet-return timing' => $this->quiet_return_review_timing_label,
        'Hold release cue' => $this->hold_release_cue_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Hold-expiry grouping digest is still minimal.');
}

public function getQuietLaneReentryOrderFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Hold-expiry group: ' . $this->hold_expiry_group_label . '.';
    $lines[] = 'Quiet-lane re-entry order: ' . $this->quiet_lane_reentry_order_label . '.';
    $lines[] = 'Hold-aging compression: ' . $this->hold_aging_compression_label . '.';
    $lines[] = 'Quiet-lane re-entry readiness: ' . $this->quiet_lane_reentry_readiness_label . '.';
    $lines[] = 'Hold aging: ' . $this->hold_aging_label . '.';
    $lines[] = 'Quiet-return timing: ' . $this->quiet_return_review_timing_label . '.';
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is already reopened, the quiet hold is no longer just expiring in place. Re-entry order collapses to the first scan position so the record stays in active human review.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet hold is overdue, expiry has already been breached. This lane belongs at the top of the human scan order and should not remain hidden in a parked posture.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet hold is due today, expiry is effectively same-day. The lane should stay near the top of the re-entry order so review happens before drift turns into avoidable delay.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet hold is approaching expiry, the lane should move into visible preparation order now. The operator still controls the return, but the sequence should already be explicit.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the quiet hold is near-term but not urgent, expiry grouping can remain compact. Re-entry order should stay visible without forcing the lane out of deliberate quiet review too early.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet hold still sits in a future review window, expiry grouping stays stable and the lane can sit lower in re-entry order while ownership and timing remain explicit.';
        } else {
            $lines[] = 'Because the quiet hold has no clear review date, expiry grouping is weak. The lane should stay in the human scan order until an operator assigns timing clearly.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already due and no owner is named, the first real ordering move is assignment. Until ownership exists, quiet re-entry order cannot stay credible.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, expiry grouping should be read as a short staging posture. Re-entry order belongs just behind active due-now lanes so drafting can turn into deliberate handback.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because the close packet already exists, the hold should not age ambiguously. Re-entry order now exists to help the operator choose the finish lane before the quiet posture turns stale.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side work is still open, expiry grouping should stay tied to visible execution timing. Re-entry order should keep the lane behind urgent reopen items but ahead of passive future holds.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because the record is intentionally timed for later finish work, expiry grouping can remain conservative. Re-entry order should stay lower until that timed window becomes the next active human checkpoint.';
    } else {
        $lines[] = 'Because finish posture is still conservative, expiry grouping and re-entry ordering remain human-owned scan tools. They clarify where a quiet lane sits without turning the workspace into automation.';
    }

    return implode(PHP_EOL, $lines);
}


public function getHoldExpiryCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Expiry collapsed / active review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Expiry compressed / reopen immediately';

            case 'Due today':
                return 'Expiry compressed / same-day review';

            case 'Due soon':
                return 'Expiry compressed / short runway';

            case 'Near-term':
                return 'Expiry compressed / near-term watch';

            case 'Future':
                return 'Expiry compressed / long quiet watch';

            case 'Unscheduled':
                return 'Expiry compressed / review date missing';
        }

        return 'Expiry compression still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Expiry compressed / assign owner first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Expiry compressed / drafting handoff';

        case 'Closure packet prepared':
            return 'Expiry compressed / lane decision pending';

        case 'Execution still open':
            return 'Expiry compressed / follow-through still open';

        case 'Prepared but not yet executed':
            return 'Expiry compressed / prepared work waiting';

        case 'Timed for later finish':
            return 'Expiry compressed / timed finish cadence';
    }

    return 'Expiry compressed / quiet human hold';
}

public function getQuietLaneCadenceLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Cadence active now / immediate review';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Cadence broken / return now';

            case 'Due today':
                return 'Cadence due today / same-day review';

            case 'Due soon':
                return 'Short cadence / prepare return';

            case 'Near-term':
                return 'Near-term cadence / keep visible';

            case 'Future':
                return 'Long cadence / hold quietly';

            case 'Unscheduled':
                return 'Cadence missing / set review date';
        }

        return 'Cadence still forming / quiet review';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Cadence blocked / assign owner first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Draft cadence / handback soon';

        case 'Closure packet prepared':
            return 'Decision cadence / choose lane';

        case 'Execution still open':
            return 'Execution cadence / resume follow-through';

        case 'Prepared but not yet executed':
            return 'Prepared cadence / start work first';

        case 'Timed for later finish':
            return 'Timed cadence / wait for finish window';
    }

    return 'Quiet cadence / human review';
}

public function getHoldExpiryCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Hold-expiry compression' => $this->hold_expiry_compression_label,
        'Quiet-lane cadence' => $this->quiet_lane_cadence_label,
        'Hold-expiry group' => $this->hold_expiry_group_label,
        'Quiet-lane re-entry order' => $this->quiet_lane_reentry_order_label,
        'Hold-aging compression' => $this->hold_aging_compression_label,
        'Quiet-lane re-entry readiness' => $this->quiet_lane_reentry_readiness_label,
        'Next review window' => $this->next_review_window_label,
        'Hold release cue' => $this->hold_release_cue_label,
    ], 'Hold-expiry compression digest is still minimal.');
}

public function getQuietLaneCadenceFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Hold-expiry compression: ' . $this->hold_expiry_compression_label . '.';
    $lines[] = 'Quiet-lane cadence: ' . $this->quiet_lane_cadence_label . '.';
    $lines[] = 'Hold-expiry group: ' . $this->hold_expiry_group_label . '.';
    $lines[] = 'Quiet-lane re-entry order: ' . $this->quiet_lane_reentry_order_label . '.';
    $lines[] = 'Hold-aging compression: ' . $this->hold_aging_compression_label . '.';
    $lines[] = 'Quiet-lane re-entry readiness: ' . $this->quiet_lane_reentry_readiness_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is already reopened, any quiet cadence has already collapsed into active review. The compressed expiry signal exists only to confirm that the record no longer belongs in silent hold posture.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the quiet cadence has already broken. Expiry compression should read as immediate human return rather than a stable hold.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet hold is due today, cadence becomes same-day. The record can stay narrow, but the timing should now be read as active review work for the current day.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet hold is approaching expiry, cadence should shorten visibly. The lane still belongs in deliberate quiet review, but the operator should prepare the return before the window slips.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the hold sits in a near-term window, cadence can remain compact and visible without forcing immediate re-entry. The point is human timing clarity, not automation.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet hold is still tied to a future review window, cadence can remain long and stable. Expiry compression stays readable so the lane does not need to be mentally rebuilt later.';
        } else {
            $lines[] = 'Because the quiet hold has no clear schedule, cadence is not yet credible. The next human move is to assign a review date so compression and return order mean something concrete.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already due and no owner is assigned, cadence should not pretend to be stable. Assignment is the first real move before any quiet hold can stay compressed.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, cadence should stay short and explicit. Expiry compression exists to keep the drafting handoff readable before the lane drifts back into passive review.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already present, cadence should stay tied to deliberate lane choice. The quiet hold can remain narrow only while the operator keeps the finish decision visible.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side work is still open, cadence should stay connected to visible follow-through timing. Compression helps the operator scan the lane quickly without hiding the unfinished work.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, cadence can remain conservative and human-owned. The compressed expiry cue simply keeps that future checkpoint visible without widening the workspace.';
    } else {
        $lines[] = 'Because finish posture is still conservative, cadence framing remains a narrow scan aid. It clarifies how often the quiet lane should surface without turning the loyalty workspace into automation.';
    }

    return implode(PHP_EOL, $lines);
}


public function getCadenceCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Cadence collapsed / active review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Cadence compressed / no silent runway left';

            case 'Due today':
                return 'Cadence compressed / same-day resurfacing';

            case 'Due soon':
                return 'Cadence compressed / short resurfacing runway';

            case 'Near-term':
                return 'Cadence compressed / near-term visible hold';

            case 'Future':
                return 'Cadence compressed / long quiet runway';

            case 'Unscheduled':
                return 'Cadence untrusted / review date missing';
        }

        return 'Cadence compression still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Cadence blocked / assign owner first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Cadence compressed / drafting should surface soon';

        case 'Closure packet prepared':
            return 'Cadence compressed / finish choice should surface';

        case 'Execution still open':
            return 'Cadence compressed / follow-through should resurface';

        case 'Prepared but not yet executed':
            return 'Cadence compressed / prepared work should surface';

        case 'Timed for later finish':
            return 'Cadence compressed / timed resurfacing later';
    }

    return 'Cadence compressed / quiet human surfacing';
}

public function getQuietLaneResurfacingPriorityLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · resurfacing now / active lane';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return '01 · overdue quiet lane / resurface now';

            case 'Due today':
                return '02 · same-day quiet lane / review today';

            case 'Due soon':
                return '03 · due-soon quiet lane / prepare next';

            case 'Near-term':
                return '04 · near-term quiet lane / keep visible';

            case 'Future':
                return '05 · future quiet lane / low resurfacing priority';

            case 'Unscheduled':
                return '03 · unscheduled quiet lane / assign timing';
        }

        return '04 · quiet lane / resurfacing order forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '02 · owner missing / assign before quiet hold';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '03 · drafting lane / surface soon';

        case 'Closure packet prepared':
            return '03 · finish choice pending / surface soon';

        case 'Execution still open':
            return '02 · execution open / resurface early';

        case 'Prepared but not yet executed':
            return '03 · prepared work / resume deliberately';

        case 'Timed for later finish':
            return '05 · timed finish / resurface on schedule';
    }

    return '06 · quiet review / conservative resurfacing';
}

public function getCadenceCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Cadence compression' => $this->cadence_compression_label,
        'Quiet-lane resurfacing priority' => $this->quiet_lane_resurfacing_priority_label,
        'Quiet-lane cadence' => $this->quiet_lane_cadence_label,
        'Hold-expiry compression' => $this->hold_expiry_compression_label,
        'Quiet-lane re-entry order' => $this->quiet_lane_reentry_order_label,
        'Quiet-lane re-entry readiness' => $this->quiet_lane_reentry_readiness_label,
        'Next review window' => $this->next_review_window_label,
        'Hold release cue' => $this->hold_release_cue_label,
    ], 'Cadence compression digest is still minimal.');
}

public function getQuietLaneResurfacingPriorityFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Cadence compression: ' . $this->cadence_compression_label . '.';
    $lines[] = 'Quiet-lane resurfacing priority: ' . $this->quiet_lane_resurfacing_priority_label . '.';
    $lines[] = 'Quiet-lane cadence: ' . $this->quiet_lane_cadence_label . '.';
    $lines[] = 'Hold-expiry compression: ' . $this->hold_expiry_compression_label . '.';
    $lines[] = 'Quiet-lane re-entry order: ' . $this->quiet_lane_reentry_order_label . '.';
    $lines[] = 'Quiet-lane re-entry readiness: ' . $this->quiet_lane_reentry_readiness_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the lane is already reopened, any quiet cadence has already surfaced. Resurfacing priority collapses to active human review now, and the compressed cadence cue simply confirms that the record no longer belongs in silent hold posture.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked review window is overdue, the quiet cadence has no safe silent runway left. Resurfacing priority belongs at the top of the human scan so the lane is reviewed deliberately now.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet hold is due today, cadence compresses into same-day work. Resurfacing priority should stay near the top of the scan order so the hold does not drift past its intended window.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet hold is approaching expiry, cadence should stay short and visible. Resurfacing priority should already be explicit so the operator prepares the return before urgency takes over.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the hold sits in a near-term window, cadence can remain compact without forcing immediate review. Resurfacing priority exists to keep the lane visible in human timing without widening into automation.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet hold still belongs to a future window, cadence can remain long and stable. Resurfacing priority should stay lower, but explicit, so the lane does not disappear from deliberate ownership.';
        } else {
            $lines[] = 'Because the quiet hold has no clear schedule, cadence cannot be trusted yet. The next human move is to assign timing so resurfacing priority means something concrete.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already due and no owner is assigned, resurfacing priority should not pretend to be stable. Assignment is the first real move before any quiet cadence can stay compressed credibly.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, cadence compression should keep the lane narrow but not hidden. Resurfacing priority exists to bring the drafting handoff back up before the finish path drifts into passive review.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already present, resurfacing priority should stay tied to finish-lane choice. The quiet posture can remain compressed only while the operator keeps that decision visible.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side work is still open, cadence compression should keep the lane readable without hiding unfinished work. Resurfacing priority should lift the record ahead of passive future holds so follow-through resumes deliberately.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, cadence can remain compressed and human-owned. Resurfacing priority should stay conservative and scheduled rather than becoming automated pressure.';
    } else {
        $lines[] = 'Because finish posture is still conservative, cadence compression and resurfacing priority remain narrow scan aids. They clarify which quiet lane should surface first without turning the workspace into automation.';
    }

    return implode(PHP_EOL, $lines);
}


public function getResurfacingCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Resurfacing collapsed / active review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Resurfacing compressed / expired quiet slot';

            case 'Due today':
                return 'Resurfacing compressed / same-day review slot';

            case 'Due soon':
                return 'Resurfacing compressed / next-slot preparation';

            case 'Near-term':
                return 'Resurfacing compressed / upcoming quiet slot';

            case 'Future':
                return 'Resurfacing compressed / deferred quiet slot';

            case 'Unscheduled':
                return 'Resurfacing untrusted / review slot missing';
        }

        return 'Resurfacing compression still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Resurfacing blocked / assign owner before slotting';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Resurfacing compressed / drafting slot should open';

        case 'Closure packet prepared':
            return 'Resurfacing compressed / finish choice slot pending';

        case 'Execution still open':
            return 'Resurfacing compressed / execution slot should reopen';

        case 'Prepared but not yet executed':
            return 'Resurfacing compressed / prepared slot should resume';

        case 'Timed for later finish':
            return 'Resurfacing compressed / future slot already chosen';
    }

    return 'Resurfacing compressed / quiet human slotting';
}

public function getQuietLaneReviewSlotLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · active slot now / leave quiet lane';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return '01 · expired quiet slot / review now';

            case 'Due today':
                return '02 · today quiet slot / review this shift';

            case 'Due soon':
                return '03 · next quiet slot / prepare review';

            case 'Near-term':
                return '04 · near-term quiet slot / keep on board';

            case 'Future':
                return '05 · future quiet slot / keep parked';

            case 'Unscheduled':
                return '03 · slot missing / assign review timing';
        }

        return '04 · quiet slot / review order forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '02 · owner missing / assign before slotting';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '03 · drafting slot / review soon';

        case 'Closure packet prepared':
            return '03 · finish choice slot / review soon';

        case 'Execution still open':
            return '02 · execution slot / reopen early';

        case 'Prepared but not yet executed':
            return '03 · prepared slot / resume deliberately';

        case 'Timed for later finish':
            return '05 · timed finish slot / review on schedule';
    }

    return '06 · quiet review slot / conservative cadence';
}

public function getResurfacingCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Resurfacing compression' => $this->resurfacing_compression_label,
        'Quiet-lane review slot' => $this->quiet_lane_review_slot_label,
        'Quiet-lane resurfacing priority' => $this->quiet_lane_resurfacing_priority_label,
        'Cadence compression' => $this->cadence_compression_label,
        'Quiet-lane cadence' => $this->quiet_lane_cadence_label,
        'Hold-expiry compression' => $this->hold_expiry_compression_label,
        'Next review window' => $this->next_review_window_label,
        'Hold release cue' => $this->hold_release_cue_label,
    ], 'Resurfacing compression digest is still minimal.');
}

public function getQuietLaneReviewSlotFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Resurfacing compression: ' . $this->resurfacing_compression_label . '.';
    $lines[] = 'Quiet-lane review slot: ' . $this->quiet_lane_review_slot_label . '.';
    $lines[] = 'Quiet-lane resurfacing priority: ' . $this->quiet_lane_resurfacing_priority_label . '.';
    $lines[] = 'Cadence compression: ' . $this->cadence_compression_label . '.';
    $lines[] = 'Quiet-lane cadence: ' . $this->quiet_lane_cadence_label . '.';
    $lines[] = 'Hold-expiry compression: ' . $this->hold_expiry_compression_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Hold release cue: ' . $this->hold_release_cue_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, quiet slotting has ended. Resurfacing compression collapses into active review now, and the review-slot cue simply confirms that the record no longer belongs in a silent hold posture.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked quiet window is overdue, the silent slot has already expired. Resurfacing compression exists to make that collapse obvious, and the review-slot cue should place the record at the front of deliberate human review.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet hold is due today, resurfacing compression should stay short and concrete. The review-slot cue keeps the record in a same-day human slot so it does not drift past its intended quiet window.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet hold is approaching expiry, resurfacing compression should keep the lane compact and visible. The review-slot cue tells the operator that preparation should begin before urgency takes over.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the hold belongs to a near-term window, resurfacing compression can stay narrow without forcing immediate work. The review-slot cue exists to reserve human attention ahead of time without widening into automation.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet hold still belongs to a future window, resurfacing compression can remain stable and conservative. The review-slot cue simply keeps a later human checkpoint visible so the lane does not disappear from ownership.';
        } else {
            $lines[] = 'Because the quiet hold has no review window yet, resurfacing compression cannot be trusted. The next human move is to assign a real review slot so timing and priority become concrete.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already due and still has no owner, review-slot framing should not pretend to be stable. Assignment is the first real move before any quiet resurfacing can stay compressed credibly.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, resurfacing compression should keep the lane visible and narrow. The review-slot cue exists to bring the drafting handoff back into a deliberate human slot before the finish path drifts into passive review.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, resurfacing compression should stay tied to finish choice rather than passive waiting. The review-slot cue keeps that decision anchored to a deliberate human checkpoint.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side work is still open, resurfacing compression should keep the lane readable without hiding unfinished follow-through. The review-slot cue should surface the record ahead of passive future holds so execution resumes deliberately.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is already intentional, resurfacing compression can stay conservative and human-owned. The review-slot cue should remain explicitly scheduled rather than turning into automated pressure.';
    } else {
        $lines[] = 'Because finish posture is still conservative, resurfacing compression and review-slot framing remain narrow scan aids. They clarify how the quiet lane should reappear in human timing without turning the loyalty workspace into automation.';
    }

    return implode(PHP_EOL, $lines);
}


public function getReviewSlotCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Review slot collapsed / active review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Review slot compressed / expired quiet checkpoint';

            case 'Due today':
                return 'Review slot compressed / same-day checkpoint';

            case 'Due soon':
                return 'Review slot compressed / next checkpoint due';

            case 'Near-term':
                return 'Review slot compressed / near-term checkpoint';

            case 'Future':
                return 'Review slot compressed / future checkpoint held';

            case 'Unscheduled':
                return 'Review slot untrusted / assign checkpoint';
        }

        return 'Review slot compression still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Review slot blocked / assign owner first';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Review slot compressed / drafting checkpoint';

        case 'Closure packet prepared':
            return 'Review slot compressed / finish-choice checkpoint';

        case 'Execution still open':
            return 'Review slot compressed / execution checkpoint';

        case 'Prepared but not yet executed':
            return 'Review slot compressed / prepared checkpoint';

        case 'Timed for later finish':
            return 'Review slot compressed / timed checkpoint';
    }

    return 'Review slot compression still forming';
}

public function getQuietLaneResurfacingCadenceGroupLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · active review slot / cadence collapsed';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return '01 · overdue slot / resurface now';

            case 'Due today':
                return '02 · same-day slot / review today';

            case 'Due soon':
                return '03 · next slot / prepare now';

            case 'Near-term':
                return '04 · near-term slot / keep visible';

            case 'Future':
                return '05 · future slot / grouped quietly';

            case 'Unscheduled':
                return '03 · slot missing / assign timing';
        }

        return '04 · quiet slot / grouping still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '02 · owner missing / assign before grouping';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '03 · drafting slot / group for review';

        case 'Closure packet prepared':
            return '03 · finish-choice slot / group for review';

        case 'Execution still open':
            return '02 · execution slot / resume early';

        case 'Prepared but not yet executed':
            return '03 · prepared slot / resume deliberately';

        case 'Timed for later finish':
            return '05 · timed slot / review on schedule';
    }

    return '06 · quiet review slot / grouped cadence';
}

public function getReviewSlotCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Review-slot compression' => $this->review_slot_compression_label,
        'Quiet-lane resurfacing cadence group' => $this->quiet_lane_resurfacing_cadence_group_label,
        'Resurfacing compression' => $this->resurfacing_compression_label,
        'Quiet-lane review slot' => $this->quiet_lane_review_slot_label,
        'Quiet-lane resurfacing priority' => $this->quiet_lane_resurfacing_priority_label,
        'Cadence compression' => $this->cadence_compression_label,
        'Quiet-lane cadence' => $this->quiet_lane_cadence_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Review-slot compression digest is still minimal.');
}

public function getQuietLaneResurfacingCadenceGroupFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Review-slot compression: ' . $this->review_slot_compression_label . '.';
    $lines[] = 'Quiet-lane resurfacing cadence group: ' . $this->quiet_lane_resurfacing_cadence_group_label . '.';
    $lines[] = 'Resurfacing compression: ' . $this->resurfacing_compression_label . '.';
    $lines[] = 'Quiet-lane review slot: ' . $this->quiet_lane_review_slot_label . '.';
    $lines[] = 'Quiet-lane resurfacing priority: ' . $this->quiet_lane_resurfacing_priority_label . '.';
    $lines[] = 'Cadence compression: ' . $this->cadence_compression_label . '.';
    $lines[] = 'Quiet-lane cadence: ' . $this->quiet_lane_cadence_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, quiet grouping has ended. The slot and cadence cues collapse into active human review now, and the grouped readout simply confirms that the record no longer belongs in a silent quiet lane.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked quiet window is overdue, grouping should collapse into immediate human review. The slot cue belongs at the front of the scan so the record resurfaces deliberately now.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet hold is due today, grouping should stay short and same-day. The slot and cadence cues exist to keep the review checkpoint visible before it drifts past the intended window.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet hold is approaching expiry, grouping should stay compact and preparatory. The point is to surface the next slot early enough for a calm human return rather than an urgent scramble.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the quiet hold belongs to a near-term window, grouping can remain narrow without forcing immediate work. The grouped cue reserves human attention ahead of time without widening into automation.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the quiet hold still belongs to a future window, grouping can remain conservative and stable. The slot cue simply keeps a later checkpoint visible so the lane does not disappear from ownership.';
        } else {
            $lines[] = 'Because the quiet hold has no review window yet, the grouping cannot be trusted. The next human move is to assign a real checkpoint so slotting, timing, and resurfacing priority become concrete.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already due and still has no owner, grouping should not pretend to be stable. Assignment is the first real move before a quiet slot can be compressed credibly.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, slot compression should keep the lane narrow but visible. Grouping exists to bring that drafting checkpoint back into a deliberate human slot before the finish path drifts into passive review.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, the grouped cue should stay tied to finish choice rather than passive waiting. The slot remains explicit so the operator can resolve the next finish decision deliberately.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side work is still open, grouping should keep the lane readable without hiding unfinished follow-through. The compressed slot should surface ahead of passive future holds so execution resumes deliberately.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, grouping can stay conservative and human-owned. The slot should remain explicitly scheduled rather than turning into automated pressure.';
    } else {
        $lines[] = 'Because finish posture is still conservative, review-slot compression and resurfacing cadence grouping remain narrow scan aids. They clarify how a quiet lane should reappear in human timing without turning the loyalty workspace into automation.';
    }

    return implode(PHP_EOL, $lines);
}


public function getCheckpointOrderingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · active review / reopen now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return '01 · expired checkpoint / immediate review';

            case 'Due today':
                return '02 · same-day checkpoint / review this shift';

            case 'Due soon':
                return '03 · next checkpoint / prepare before drift';

            case 'Near-term':
                return '04 · near-term checkpoint / keep queued';

            case 'Future':
                return '05 · future checkpoint / keep parked';

            case 'Unscheduled':
                return '03 · checkpoint missing / assign timing';
        }

        return '04 · quiet checkpoint / ordering still forming';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '02 · owner missing / assign before ordering';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '03 · drafting checkpoint / schedule now';

        case 'Closure packet prepared':
            return '03 · finish-choice checkpoint / resolve soon';

        case 'Execution still open':
            return '02 · execution checkpoint / resume early';

        case 'Prepared but not yet executed':
            return '03 · prepared checkpoint / resume deliberately';

        case 'Timed for later finish':
            return '05 · timed checkpoint / keep scheduled';
    }

    return '06 · conservative checkpoint / ordering forming';
}

public function getQuietLaneScanPairCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'List + detail aligned / active review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'List + detail aligned / resurface now';

            case 'Due today':
                return 'List + detail aligned / same-day review';

            case 'Due soon':
                return 'List + detail aligned / prepare next slot';

            case 'Near-term':
                return 'List + detail aligned / keep visible';

            case 'Future':
                return 'List + detail aligned / quiet future hold';

            case 'Unscheduled':
                return 'Pair untrusted / assign slot first';
        }

        return 'Pair still forming / keep quiet lane narrow';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Pair blocked / owner before quiet pairing';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'List + detail aligned / drafting slot next';

        case 'Closure packet prepared':
            return 'List + detail aligned / finish choice next';

        case 'Execution still open':
            return 'List + detail aligned / execution resume next';

        case 'Prepared but not yet executed':
            return 'List + detail aligned / prepared resume next';

        case 'Timed for later finish':
            return 'List + detail aligned / timed finish hold';
    }

    return 'List + detail aligned / conservative quiet pairing';
}

public function getCheckpointOrderingDigestAttribute(): string
{
    return $this->formatSummary([
        'Checkpoint ordering' => $this->checkpoint_ordering_label,
        'Quiet-lane scan-pair compression' => $this->quiet_lane_scan_pair_compression_label,
        'Review-slot compression' => $this->review_slot_compression_label,
        'Quiet-lane resurfacing cadence group' => $this->quiet_lane_resurfacing_cadence_group_label,
        'Quiet-lane review slot' => $this->quiet_lane_review_slot_label,
        'Quiet-lane resurfacing priority' => $this->quiet_lane_resurfacing_priority_label,
        'Quiet-lane cadence' => $this->quiet_lane_cadence_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Checkpoint ordering digest is still minimal.');
}

public function getQuietLaneScanPairCompressionFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Checkpoint ordering: ' . $this->checkpoint_ordering_label . '.';
    $lines[] = 'Quiet-lane scan-pair compression: ' . $this->quiet_lane_scan_pair_compression_label . '.';
    $lines[] = 'Review-slot compression: ' . $this->review_slot_compression_label . '.';
    $lines[] = 'Quiet-lane resurfacing cadence group: ' . $this->quiet_lane_resurfacing_cadence_group_label . '.';
    $lines[] = 'Quiet-lane review slot: ' . $this->quiet_lane_review_slot_label . '.';
    $lines[] = 'Quiet-lane resurfacing priority: ' . $this->quiet_lane_resurfacing_priority_label . '.';
    $lines[] = 'Quiet-lane cadence: ' . $this->quiet_lane_cadence_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, checkpoint ordering should collapse to active human review. The scan pair simply confirms that the list view and linked inquiry snapshot should now tell the same immediate story.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet checkpoint is overdue, ordering should move the record to the front of deliberate review. The scan pair exists so the loyalty list and linked inquiry snapshot both surface that same immediate return cue without extra regrouping.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet checkpoint is due today, ordering should stay same-day and concrete. The scan pair keeps the list cue and the detail cue aligned so the record does not drift past its intended review window.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the checkpoint is approaching, ordering should stay preparatory instead of urgent. The scan pair keeps both surfaces aligned around the next quiet slot before pressure widens the workspace.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the checkpoint is near-term, ordering can stay narrow and calm. The scan pair exists to preserve the same quiet story in both the list and linked inquiry snapshot without pretending the record is active now.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the checkpoint still belongs to a future window, ordering should remain conservative and operator-owned. The scan pair keeps that future hold visible across both surfaces without turning it into automation.';
        } else {
            $lines[] = 'Because the quiet checkpoint is not yet scheduled, ordering cannot be trusted. The next human move is to assign a real slot so the list cue and linked detail cue can compress into one believable pair.';
        }
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already due and still has no owner, checkpoint ordering should not pretend to be stable. Assignment is the first real move before quiet pairing can stay compressed credibly across the list and linked inquiry snapshot.';
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, ordering should keep the drafting checkpoint visible without widening the workspace. The scan pair keeps that next move aligned between the loyalty list and linked inquiry detail.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, ordering should stay tied to finish choice rather than passive waiting. The scan pair exists to keep both surfaces pointed at the same finish decision.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side work is still open, ordering should surface the next execution checkpoint before the record slips back into passive quiet timing. The scan pair keeps both surfaces aligned on that resume posture.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, ordering can remain conservative and scheduled. The scan pair keeps that scheduled hold readable in both places without turning the loyalty workspace into automation.';
    } else {
        $lines[] = 'Because finish posture is still conservative, checkpoint ordering and quiet-lane scan-pair compression remain narrow human scan aids. They reduce regrouping between the loyalty list and linked inquiry snapshot without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getOwnerFirstCheckpointPairingLabelAttribute(): string
{
    if (trim((string) $this->owner_name) === '') {
        if ($this->latest_finish_lane_state === 'reopened') {
            return 'Owner missing / reopened lane needs named lead';
        }

        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Owner missing / overdue checkpoint blocked';

            case 'Due today':
                return 'Owner missing / same-day checkpoint blocked';

            case 'Due soon':
                return 'Owner first / due-soon checkpoint next';

            case 'Near-term':
                return 'Owner first / near-term checkpoint queued';

            case 'Future':
                return 'Owner first / future checkpoint parked';

            case 'Unscheduled':
                return 'Owner first / checkpoint timing still open';
        }

        return 'Owner first / checkpoint pairing still forming';
    }

    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Owner set / reopened checkpoint first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Owner set / overdue checkpoint first';

            case 'Due today':
                return 'Owner set / same-day checkpoint';

            case 'Due soon':
                return 'Owner set / next quiet checkpoint';

            case 'Near-term':
                return 'Owner set / near-term checkpoint';

            case 'Future':
                return 'Owner set / future checkpoint hold';

            case 'Unscheduled':
                return 'Owner set / assign checkpoint timing';
        }

        return 'Owner set / checkpoint pairing stabilizing';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Owner set / drafting checkpoint next';

        case 'Closure packet prepared':
            return 'Owner set / finish choice checkpoint';

        case 'Execution still open':
            return 'Owner set / execution checkpoint first';

        case 'Prepared but not yet executed':
            return 'Owner set / prepared checkpoint next';

        case 'Timed for later finish':
            return 'Owner set / timed checkpoint hold';
    }

    return 'Owner set / conservative checkpoint pairing';
}

public function getQuietLaneReturnScanCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return scan collapsed / active lane reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return scan visible / owner before same-day read';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return scan visible / pull back now';

            case 'Due today':
                return 'Return scan visible / same-day read';

            case 'Due soon':
                return 'Return scan visible / next-slot read';

            case 'Near-term':
                return 'Return scan visible / near-term read';

            case 'Future':
                return 'Return scan visible / future quiet hold';

            case 'Unscheduled':
                return 'Return scan open / assign slot first';
        }

        return 'Return scan forming / keep quiet lane narrow';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return scan narrow / drafting handback visible';

        case 'Closure packet prepared':
            return 'Return scan narrow / finish choice visible';

        case 'Execution still open':
            return 'Return scan narrow / execution resume visible';

        case 'Prepared but not yet executed':
            return 'Return scan narrow / prepared resume visible';

        case 'Timed for later finish':
            return 'Return scan narrow / timed hold visible';
    }

    return 'Return scan narrow / conservative quiet read';
}

public function getOwnerFirstCheckpointPairingDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-first checkpoint pairing' => $this->owner_first_checkpoint_pairing_label,
        'Quiet-lane return scan compression' => $this->quiet_lane_return_scan_compression_label,
        'Checkpoint ordering' => $this->checkpoint_ordering_label,
        'Quiet-lane scan-pair compression' => $this->quiet_lane_scan_pair_compression_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Return timing' => $this->quiet_return_review_timing_label,
        'Hold release' => $this->hold_release_cue_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Owner-first checkpoint pairing digest is still minimal.');
}

public function getQuietLaneReturnScanCompressionFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-first checkpoint pairing: ' . $this->owner_first_checkpoint_pairing_label . '.';
    $lines[] = 'Quiet-lane return scan compression: ' . $this->quiet_lane_return_scan_compression_label . '.';
    $lines[] = 'Checkpoint ordering: ' . $this->checkpoint_ordering_label . '.';
    $lines[] = 'Quiet-lane scan-pair compression: ' . $this->quiet_lane_scan_pair_compression_label . '.';
    $lines[] = 'Quiet-lane return: ' . $this->quiet_lane_return_label . '.';
    $lines[] = 'Return timing: ' . $this->quiet_return_review_timing_label . '.';
    $lines[] = 'Hold release: ' . $this->hold_release_cue_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the record is already reopened, the quiet-lane return scan should collapse into active handling. Owner-first pairing matters here because a named operator should read and carry the reopened checkpoint before any quiet return language stays on screen.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is due and still has no owner, quiet-lane return compression cannot pretend the scan is stable. The first human move is still assignment, and only then should the return cue compress into one believable same-day read.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet return is already overdue, owner-first pairing should keep the record in deliberate human view. The return scan compresses the list cue and detail cue into one immediate pull-back signal rather than scattering the story across multiple panels.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, pairing should stay owner-visible and concrete. The quiet-lane return scan exists so the list view and the linked inquiry snapshot both express the same same-day checkpoint without extra regrouping.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is approaching, owner-first pairing should stay preparatory instead of urgent. The compressed return scan keeps the next quiet checkpoint readable before the record drifts into a wider queue posture.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the pairing can stay calm and operator-owned. The compressed scan preserves that quiet timing read across both surfaces without overstating urgency.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return belongs to a future quiet window, owner-first pairing should hold the record in a conservative parked state. The compressed scan keeps that future handback visible without turning the workspace into automation.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, owner-first pairing should not promise stability. The next human move is to set a real checkpoint so the quiet-lane return scan can compress around a truthful time signal.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, owner-first pairing should keep the drafting checkpoint visible. The quiet-lane return scan simply keeps the handback story narrow and readable between the loyalty list and linked inquiry snapshot.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, owner-first pairing should stay tied to finish choice. The quiet-lane return scan keeps that prepared handback visible without widening the workspace.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate move, owner-first pairing should keep the named operator and next checkpoint in view. The return scan compresses the handback story so both surfaces stay aligned on that resume posture.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, owner-first pairing can remain conservative and scheduled. The quiet-lane return scan keeps the eventual handback visible without pretending the record should be active right now.';
    } else {
        $lines[] = 'Because finish posture is still quiet and conservative, owner-first pairing and quiet-lane return scan compression remain human scan aids only. They reduce list/detail translation without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}




public function getSameDayCheckpointCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Same-day checkpoint collapsed / reopened lane active';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Same-day checkpoint blocked / owner still missing';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Same-day checkpoint active / owner return now';

            case 'Due today':
                return 'Same-day checkpoint active / due today';

            case 'Due soon':
                return 'Same-day checkpoint staged / same-day prep next';

            case 'Near-term':
                return 'Same-day checkpoint staged / near-term prep';

            case 'Future':
                return 'Same-day checkpoint parked / future owner hold';

            case 'Unscheduled':
                return 'Same-day checkpoint open / timing still missing';
        }

        return 'Same-day checkpoint forming / quiet lane compressed';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Same-day checkpoint narrow / drafting handback next';

        case 'Closure packet prepared':
            return 'Same-day checkpoint narrow / finish choice next';

        case 'Execution still open':
            return 'Same-day checkpoint narrow / execution resume next';

        case 'Prepared but not yet executed':
            return 'Same-day checkpoint narrow / prepared resume next';

        case 'Timed for later finish':
            return 'Same-day checkpoint narrow / later finish hold';
    }

    return 'Same-day checkpoint narrow / conservative owner read';
}

public function getOwnerVisibleQuietLaneReturnHandbackLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return handback explicit / active lane reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return handback blocked / name owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return handback explicit / owner pull-back now';

            case 'Due today':
                return 'Return handback explicit / same-day owner handback';

            case 'Due soon':
                return 'Return handback visible / next-slot owner handback';

            case 'Near-term':
                return 'Return handback visible / near-term owner handback';

            case 'Future':
                return 'Return handback visible / future quiet owner hold';

            case 'Unscheduled':
                return 'Return handback open / set owner checkpoint first';
        }

        return 'Return handback forming / keep owner visible';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return handback narrow / drafting owner visible';

        case 'Closure packet prepared':
            return 'Return handback narrow / finish choice visible';

        case 'Execution still open':
            return 'Return handback narrow / execution resume visible';

        case 'Prepared but not yet executed':
            return 'Return handback narrow / prepared resume visible';

        case 'Timed for later finish':
            return 'Return handback narrow / timed owner hold';
    }

    return 'Return handback narrow / conservative owner-visible read';
}

public function getSameDayCheckpointCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Same-day checkpoint compression' => $this->same_day_checkpoint_compression_label,
        'Owner-visible quiet-lane return handback' => $this->owner_visible_quiet_lane_return_handback_label,
        'Owner-first checkpoint pairing' => $this->owner_first_checkpoint_pairing_label,
        'Quiet-lane return scan compression' => $this->quiet_lane_return_scan_compression_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Same-day checkpoint compression digest is still minimal.');
}

public function getOwnerVisibleQuietLaneReturnHandbackFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Same-day checkpoint compression: ' . $this->same_day_checkpoint_compression_label . '.';
    $lines[] = 'Owner-visible quiet-lane return handback: ' . $this->owner_visible_quiet_lane_return_handback_label . '.';
    $lines[] = 'Owner-first checkpoint pairing: ' . $this->owner_first_checkpoint_pairing_label . '.';
    $lines[] = 'Quiet-lane return scan compression: ' . $this->quiet_lane_return_scan_compression_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, same-day compression should collapse into active human handling. The owner-visible handback frame exists only so the list cue, overview cue, and linked inquiry snapshot keep the named lead and return posture aligned.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no owner, same-day compression should not pretend the checkpoint is stable. The first real move is to name the operator so the quiet-lane handback can become truthful across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, same-day compression should pull the record back into deliberate view now. The owner-visible handback keeps that pull-back tied to one named operator instead of scattering the story across multiple quiet-lane cues.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should compress to one concrete same-day checkpoint. The owner-visible handback makes the same-day move explicit in the loyalty list, overview workspace, and linked inquiry snapshot without widening the workflow.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, same-day compression should stay preparatory and narrow. The owner-visible handback keeps the next quiet checkpoint attached to a named lead before urgency increases.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay calm and operator-owned. Same-day compression simply preserves the next checkpoint shape early, while the owner-visible handback keeps the quiet return readable across both list and detail surfaces.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, same-day compression remains conservative and parked. The owner-visible handback exists so the future hold still names the responsible lead without turning the workspace into automation.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, same-day compression cannot honestly form yet. The next human move is to set a real checkpoint so the handback can stay narrow, owner-visible, and believable.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, same-day compression should keep the drafting checkpoint visible. The owner-visible handback keeps the responsible lead attached to that close-side move without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, same-day compression should stay tied to the finish choice checkpoint. The owner-visible handback keeps that prepared move readable as a named handback rather than a generic quiet return.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, same-day compression should keep the next resume checkpoint visible. The owner-visible handback ensures the handoff remains attached to a real lead across the loyalty list and linked inquiry snapshot.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, same-day compression stays conservative and scheduled. The owner-visible handback keeps the eventual return checkpoint named and quiet without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, same-day checkpoint compression and owner-visible quiet-lane return handback framing remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getOwnerConfirmedSameDayHandbackCueLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Owner-confirmed handback bypassed / lane already reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Owner-confirmed handback blocked / assign owner now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Owner-confirmed handback now / same-day checkpoint due';

            case 'Due today':
                return 'Owner-confirmed handback set / same-day move confirmed';

            case 'Due soon':
                return 'Owner-confirmed handback staged / next-slot confirm';

            case 'Near-term':
                return 'Owner-confirmed handback staged / near-term confirm';

            case 'Future':
                return 'Owner-confirmed handback parked / future owner hold';

            case 'Unscheduled':
                return 'Owner-confirmed handback open / set return checkpoint';
        }

        return 'Owner-confirmed handback forming / quiet lane aligned';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Owner-confirmed handback narrow / drafting checkpoint confirmed';

        case 'Closure packet prepared':
            return 'Owner-confirmed handback narrow / finish choice confirmed';

        case 'Execution still open':
            return 'Owner-confirmed handback narrow / execution resume confirmed';

        case 'Prepared but not yet executed':
            return 'Owner-confirmed handback narrow / prepared resume confirmed';

        case 'Timed for later finish':
            return 'Owner-confirmed handback narrow / later finish hold';
    }

    return 'Owner-confirmed handback narrow / conservative same-day read';
}

public function getQuietLaneReturnCheckpointPolishLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return checkpoint active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return checkpoint blocked / owner still unnamed';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return checkpoint polished / overdue pull-back now';

            case 'Due today':
                return 'Return checkpoint polished / same-day return visible';

            case 'Due soon':
                return 'Return checkpoint polished / next-slot return visible';

            case 'Near-term':
                return 'Return checkpoint polished / near-term return visible';

            case 'Future':
                return 'Return checkpoint polished / future quiet hold';

            case 'Unscheduled':
                return 'Return checkpoint open / set review timing first';
        }

        return 'Return checkpoint forming / quiet lane kept readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return checkpoint narrow / drafting return readable';

        case 'Closure packet prepared':
            return 'Return checkpoint narrow / finish choice readable';

        case 'Execution still open':
            return 'Return checkpoint narrow / execution resume readable';

        case 'Prepared but not yet executed':
            return 'Return checkpoint narrow / prepared resume readable';

        case 'Timed for later finish':
            return 'Return checkpoint narrow / timed quiet hold';
    }

    return 'Return checkpoint narrow / conservative quiet return read';
}

public function getOwnerConfirmedSameDayHandbackCueDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-confirmed same-day handback cue' => $this->owner_confirmed_same_day_handback_cue_label,
        'Quiet-lane return checkpoint polish' => $this->quiet_lane_return_checkpoint_polish_label,
        'Same-day checkpoint compression' => $this->same_day_checkpoint_compression_label,
        'Owner-visible quiet-lane return handback' => $this->owner_visible_quiet_lane_return_handback_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-confirmed same-day handback cue digest is still minimal.');
}

public function getQuietLaneReturnCheckpointPolishFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-confirmed same-day handback cue: ' . $this->owner_confirmed_same_day_handback_cue_label . '.';
    $lines[] = 'Quiet-lane return checkpoint polish: ' . $this->quiet_lane_return_checkpoint_polish_label . '.';
    $lines[] = 'Same-day checkpoint compression: ' . $this->same_day_checkpoint_compression_label . '.';
    $lines[] = 'Owner-visible quiet-lane return handback: ' . $this->owner_visible_quiet_lane_return_handback_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, owner-confirmed same-day handback cueing should collapse into active handling rather than quiet framing. The return checkpoint polish simply keeps the reopened checkpoint readable across the list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no owner, owner-confirmed handback cueing cannot become truthful yet. The first real move is to name the operator so the return checkpoint can be polished into a believable same-day control point across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the same-day handback should be pulled into deliberate view now. The owner-confirmed cue keeps that overdue move tied to one named lead, while the return checkpoint polish narrows the next control point so it scans cleanly in both the loyalty list and linked inquiry snapshot.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-confirmed same-day handback and one polished return checkpoint. This keeps the immediate move concrete without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, the handback cue should stay confirmed but calm. The return checkpoint polish keeps the next slot readable early, before the quiet-lane story becomes urgent.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The handback cue simply confirms who carries the next move, while the return checkpoint polish keeps timing readable across list, overview, and inquiry surfaces.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, owner-confirmed cueing remains parked and narrow. The return checkpoint polish exists so the future hold still has one readable control point without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, owner-confirmed cueing cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can be polished into a credible, owner-held next step.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, owner-confirmed cueing should keep the drafting handback visibly attached to one lead. The return checkpoint polish keeps that close-side checkpoint readable without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, owner-confirmed cueing should stay tied to the finish choice checkpoint. The return checkpoint polish keeps that prepared move narrow, readable, and grounded in one named owner.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, owner-confirmed cueing should keep the next resume checkpoint visibly attached to one lead. The return checkpoint polish makes that resume posture easier to scan across the loyalty list and linked inquiry snapshot.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, owner-confirmed cueing stays conservative and scheduled. The return checkpoint polish simply keeps the eventual return control point visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-confirmed same-day handback cueing and quiet-lane return checkpoint polish remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}




public function getOwnerVisibleSameDayAcknowledgementCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Ack compression bypassed / lane already reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Ack compression blocked / owner still unnamed';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Ack compression visible / overdue owner acknowledgement';

            case 'Due today':
                return 'Ack compression visible / same-day owner acknowledgement';

            case 'Due soon':
                return 'Ack compression staged / next-slot owner acknowledgement';

            case 'Near-term':
                return 'Ack compression staged / near-term owner acknowledgement';

            case 'Future':
                return 'Ack compression parked / future owner hold';

            case 'Unscheduled':
                return 'Ack compression open / set return checkpoint';
        }

        return 'Ack compression forming / owner-visible quiet lane';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Ack compression narrow / drafting move owner-visible';

        case 'Closure packet prepared':
            return 'Ack compression narrow / finish choice owner-visible';

        case 'Execution still open':
            return 'Ack compression narrow / execution resume owner-visible';

        case 'Prepared but not yet executed':
            return 'Ack compression narrow / prepared resume owner-visible';

        case 'Timed for later finish':
            return 'Ack compression narrow / later finish owner hold';
    }

    return 'Ack compression narrow / conservative owner-visible read';
}

public function getQuietLaneReturnConfirmationFramingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return confirmation active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return confirmation blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return confirmation framed / overdue quiet return now';

            case 'Due today':
                return 'Return confirmation framed / same-day quiet return confirmed';

            case 'Due soon':
                return 'Return confirmation staged / next-slot quiet return';

            case 'Near-term':
                return 'Return confirmation staged / near-term quiet return';

            case 'Future':
                return 'Return confirmation parked / future quiet hold';

            case 'Unscheduled':
                return 'Return confirmation open / set review timing first';
        }

        return 'Return confirmation forming / quiet lane kept readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return confirmation narrow / drafting return confirmed';

        case 'Closure packet prepared':
            return 'Return confirmation narrow / finish choice confirmed';

        case 'Execution still open':
            return 'Return confirmation narrow / execution resume confirmed';

        case 'Prepared but not yet executed':
            return 'Return confirmation narrow / prepared resume confirmed';

        case 'Timed for later finish':
            return 'Return confirmation narrow / timed quiet hold';
    }

    return 'Return confirmation narrow / conservative quiet return read';
}

public function getOwnerVisibleSameDayAcknowledgementCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-visible same-day acknowledgement compression' => $this->owner_visible_same_day_acknowledgement_compression_label,
        'Quiet-lane return confirmation framing' => $this->quiet_lane_return_confirmation_framing_label,
        'Owner-held return checkpoint compression' => $this->owner_held_return_checkpoint_compression_label,
        'Same-day quiet-lane acknowledgement polish' => $this->same_day_quiet_lane_acknowledgement_polish_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-visible same-day acknowledgement compression digest is still minimal.');
}

public function getQuietLaneReturnConfirmationFramingFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-visible same-day acknowledgement compression: ' . $this->owner_visible_same_day_acknowledgement_compression_label . '.';
    $lines[] = 'Quiet-lane return confirmation framing: ' . $this->quiet_lane_return_confirmation_framing_label . '.';
    $lines[] = 'Owner-held return checkpoint compression: ' . $this->owner_held_return_checkpoint_compression_label . '.';
    $lines[] = 'Same-day quiet-lane acknowledgement polish: ' . $this->same_day_quiet_lane_acknowledgement_polish_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, acknowledgement compression should collapse into active handling instead of quiet framing. The return confirmation frame simply keeps the reopened checkpoint readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, acknowledgement compression cannot become truthful yet. The first real move is to assign the operator so the quiet-lane return can be confirmed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one owner-visible acknowledgement and one explicit return confirmation. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-visible same-day acknowledgement and one quiet-lane return confirmation. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, acknowledgement compression can stay calm and owner-visible before urgency rises. The return confirmation frame keeps the next slot readable early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The acknowledgement compression keeps the likely same-day move named, while the return confirmation frame keeps the next quiet-lane checkpoint aligned across every surface.';
        } elseif ($this->next_review_window_label == 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the acknowledgement can stay compressed and parked. The return confirmation frame exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, acknowledgement compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one owner-visible acknowledgement and one believable confirmation frame.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, acknowledgement compression should keep the drafting return visibly attached to one owner. The return confirmation frame keeps that likely same-day move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, acknowledgement compression should stay tied to the finish-choice control point. The return confirmation frame keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, acknowledgement compression should keep the next resume signal owner-visible. The return confirmation frame makes that same-day resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, acknowledgement compression stays conservative and scheduled. The return confirmation frame simply keeps the eventual return control point visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-visible same-day acknowledgement compression and quiet-lane return confirmation framing remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}



public function getOwnerTaggedReturnConfirmationCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Tagged return active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Tagged return blocked / owner still unnamed';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Tagged return visible / overdue owner-tagged confirmation';

            case 'Due today':
                return 'Tagged return visible / same-day owner-tagged confirmation';

            case 'Due soon':
                return 'Tagged return staged / next-slot owner tag';

            case 'Near-term':
                return 'Tagged return staged / near-term owner tag';

            case 'Future':
                return 'Tagged return parked / future owner tag';

            case 'Unscheduled':
                return 'Tagged return open / set acceptance timing first';
        }

        return 'Tagged return forming / owner-tagged quiet lane';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Tagged return narrow / drafting confirmation tagged';

        case 'Closure packet prepared':
            return 'Tagged return narrow / finish choice tagged';

        case 'Execution still open':
            return 'Tagged return narrow / execution resume tagged';

        case 'Prepared but not yet executed':
            return 'Tagged return narrow / prepared resume tagged';

        case 'Timed for later finish':
            return 'Tagged return narrow / later finish owner tag';
    }

    return 'Tagged return narrow / conservative owner-tagged read';
}

public function getSameDayQuietLaneAcceptanceFramingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Quiet acceptance active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Quiet acceptance blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Quiet acceptance framed / overdue same-day acceptance now';

            case 'Due today':
                return 'Quiet acceptance framed / same-day quiet lane accepted';

            case 'Due soon':
                return 'Quiet acceptance staged / next-slot quiet acceptance';

            case 'Near-term':
                return 'Quiet acceptance staged / near-term quiet acceptance';

            case 'Future':
                return 'Quiet acceptance parked / future quiet hold';

            case 'Unscheduled':
                return 'Quiet acceptance open / set review timing first';
        }

        return 'Quiet acceptance forming / same-day quiet lane readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Quiet acceptance narrow / drafting acceptance framed';

        case 'Closure packet prepared':
            return 'Quiet acceptance narrow / finish choice framed';

        case 'Execution still open':
            return 'Quiet acceptance narrow / execution resume framed';

        case 'Prepared but not yet executed':
            return 'Quiet acceptance narrow / prepared resume framed';

        case 'Timed for later finish':
            return 'Quiet acceptance narrow / timed quiet hold';
    }

    return 'Quiet acceptance narrow / conservative same-day read';
}

public function getOwnerTaggedReturnConfirmationCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-tagged return confirmation compression' => $this->owner_tagged_return_confirmation_compression_label,
        'Same-day quiet-lane acceptance framing' => $this->same_day_quiet_lane_acceptance_framing_label,
        'Owner-visible same-day acknowledgement compression' => $this->owner_visible_same_day_acknowledgement_compression_label,
        'Quiet-lane return confirmation framing' => $this->quiet_lane_return_confirmation_framing_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-tagged return confirmation compression digest is still minimal.');
}

public function getSameDayQuietLaneAcceptanceFramingFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-tagged return confirmation compression: ' . $this->owner_tagged_return_confirmation_compression_label . '.';
    $lines[] = 'Same-day quiet-lane acceptance framing: ' . $this->same_day_quiet_lane_acceptance_framing_label . '.';
    $lines[] = 'Owner-visible same-day acknowledgement compression: ' . $this->owner_visible_same_day_acknowledgement_compression_label . '.';
    $lines[] = 'Quiet-lane return confirmation framing: ' . $this->quiet_lane_return_confirmation_framing_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, tagged return compression should collapse into active handling instead of quiet framing. The same-day quiet acceptance frame simply keeps the reopened checkpoint readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, tagged return compression cannot become truthful yet. The first real move is to assign the operator so the same-day quiet-lane acceptance can be framed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one owner-tagged return confirmation and one same-day quiet acceptance frame. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-tagged confirmation and one same-day quiet acceptance. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, tagged return compression can stay calm and owner-led before urgency rises. The quiet acceptance frame keeps the next slot readable early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The tagged return compression keeps the likely next move named, while the same-day quiet acceptance frame keeps the lane readable across every surface.';
        } elseif ($this->next_review_window_label == 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the tagged confirmation can stay compressed and parked. The same-day quiet acceptance frame exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, tagged return compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one owner-tagged confirmation and one believable same-day acceptance frame.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, tagged return compression should keep the drafting return visibly attached to one owner. The same-day quiet acceptance frame keeps that likely move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, tagged return compression should stay tied to the finish-choice control point. The same-day quiet acceptance frame keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, tagged return compression should keep the next resume signal owner-tagged. The same-day quiet acceptance frame makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, tagged return compression stays conservative and scheduled. The same-day quiet acceptance frame simply keeps the eventual return control point visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-tagged return confirmation compression and same-day quiet-lane acceptance framing remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getOwnerHeldQuietLaneAcceptanceCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Held acceptance bypassed / lane already reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Held acceptance blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Held acceptance compressed / overdue owner-held quiet lane';

            case 'Due today':
                return 'Held acceptance compressed / same-day owner-held quiet lane';

            case 'Due soon':
                return 'Held acceptance staged / next-slot owner-held quiet lane';

            case 'Near-term':
                return 'Held acceptance staged / near-term owner-held quiet lane';

            case 'Future':
                return 'Held acceptance parked / future owner-held quiet lane';

            case 'Unscheduled':
                return 'Held acceptance open / set quiet checkpoint first';
        }

        return 'Held acceptance forming / owner-held quiet lane readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Held acceptance narrow / drafting move owner-held';

        case 'Closure packet prepared':
            return 'Held acceptance narrow / finish choice owner-held';

        case 'Execution still open':
            return 'Held acceptance narrow / execution resume owner-held';

        case 'Prepared but not yet executed':
            return 'Held acceptance narrow / prepared resume owner-held';

        case 'Timed for later finish':
            return 'Held acceptance narrow / later finish owner-held';
    }

    return 'Held acceptance narrow / conservative owner-held read';
}

public function getTaggedReturnCheckpointFramingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Tagged checkpoint active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Tagged checkpoint blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Tagged checkpoint framed / overdue quiet return now';

            case 'Due today':
                return 'Tagged checkpoint framed / same-day quiet return tagged';

            case 'Due soon':
                return 'Tagged checkpoint staged / next-slot quiet return';

            case 'Near-term':
                return 'Tagged checkpoint staged / near-term quiet return';

            case 'Future':
                return 'Tagged checkpoint parked / future quiet hold';

            case 'Unscheduled':
                return 'Tagged checkpoint open / set review timing first';
        }

        return 'Tagged checkpoint forming / quiet lane kept readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Tagged checkpoint narrow / drafting return tagged';

        case 'Closure packet prepared':
            return 'Tagged checkpoint narrow / finish choice tagged';

        case 'Execution still open':
            return 'Tagged checkpoint narrow / execution resume tagged';

        case 'Prepared but not yet executed':
            return 'Tagged checkpoint narrow / prepared resume tagged';

        case 'Timed for later finish':
            return 'Tagged checkpoint narrow / timed quiet hold';
    }

    return 'Tagged checkpoint narrow / conservative quiet return read';
}

public function getOwnerHeldQuietLaneAcceptanceCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-held quiet-lane acceptance compression' => $this->owner_held_quiet_lane_acceptance_compression_label,
        'Tagged return checkpoint framing' => $this->tagged_return_checkpoint_framing_label,
        'Owner-tagged return confirmation compression' => $this->owner_tagged_return_confirmation_compression_label,
        'Same-day quiet-lane acceptance framing' => $this->same_day_quiet_lane_acceptance_framing_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-held quiet-lane acceptance compression digest is still minimal.');
}

public function getTaggedReturnCheckpointFramingFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-held quiet-lane acceptance compression: ' . $this->owner_held_quiet_lane_acceptance_compression_label . '.';
    $lines[] = 'Tagged return checkpoint framing: ' . $this->tagged_return_checkpoint_framing_label . '.';
    $lines[] = 'Owner-tagged return confirmation compression: ' . $this->owner_tagged_return_confirmation_compression_label . '.';
    $lines[] = 'Same-day quiet-lane acceptance framing: ' . $this->same_day_quiet_lane_acceptance_framing_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, held acceptance compression should collapse into active handling instead of quiet framing. The tagged return checkpoint frame simply keeps the reopened control point readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, held acceptance compression cannot become truthful yet. The first real move is to assign the operator so the tagged return checkpoint can stay credible across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one owner-held acceptance cue and one tagged return checkpoint. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-held quiet acceptance and one tagged return checkpoint. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, held acceptance compression can stay calm and owner-held before urgency rises. The tagged checkpoint frame keeps the next slot readable early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The held acceptance compression keeps the likely same-day move named, while the tagged checkpoint frame keeps the next quiet-lane control point aligned across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the held acceptance can stay compressed and parked. The tagged checkpoint frame exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, held acceptance compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one owner-held acceptance and one believable tagged checkpoint.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, held acceptance compression should keep the drafting move visibly attached to one owner. The tagged return checkpoint frame keeps that likely move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, held acceptance compression should stay tied to the finish-choice control point. The tagged return checkpoint frame keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, held acceptance compression should keep the next resume signal owner-held. The tagged return checkpoint frame makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, held acceptance compression stays conservative and scheduled. The tagged return checkpoint frame simply keeps the eventual return control point visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-held quiet-lane acceptance compression and tagged return checkpoint framing remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getOwnerVisibleAcceptanceHandoffCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Acceptance handoff bypassed / lane already reopened';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Acceptance handoff blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Acceptance handoff compressed / overdue owner-visible quiet lane';

            case 'Due today':
                return 'Acceptance handoff compressed / same-day owner-visible quiet lane';

            case 'Due soon':
                return 'Acceptance handoff staged / next-slot owner-visible quiet lane';

            case 'Near-term':
                return 'Acceptance handoff staged / near-term owner-visible quiet lane';

            case 'Future':
                return 'Acceptance handoff parked / future owner-visible quiet lane';

            case 'Unscheduled':
                return 'Acceptance handoff open / set quiet checkpoint first';
        }

        return 'Acceptance handoff forming / owner-visible quiet lane readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Acceptance handoff narrow / drafting move owner-visible';

        case 'Closure packet prepared':
            return 'Acceptance handoff narrow / finish choice owner-visible';

        case 'Execution still open':
            return 'Acceptance handoff narrow / execution resume owner-visible';

        case 'Prepared but not yet executed':
            return 'Acceptance handoff narrow / prepared resume owner-visible';

        case 'Timed for later finish':
            return 'Acceptance handoff narrow / later finish owner-visible';
    }

    return 'Acceptance handoff narrow / conservative owner-visible read';
}

public function getQuietLaneReturnCheckpointAlignmentLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return checkpoint active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return checkpoint blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return checkpoint aligned / overdue quiet return now';

            case 'Due today':
                return 'Return checkpoint aligned / same-day quiet return readable';

            case 'Due soon':
                return 'Return checkpoint staged / next-slot quiet return';

            case 'Near-term':
                return 'Return checkpoint staged / near-term quiet return';

            case 'Future':
                return 'Return checkpoint parked / future quiet hold';

            case 'Unscheduled':
                return 'Return checkpoint open / set review timing first';
        }

        return 'Return checkpoint forming / quiet lane kept readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return checkpoint narrow / drafting return aligned';

        case 'Closure packet prepared':
            return 'Return checkpoint narrow / finish choice aligned';

        case 'Execution still open':
            return 'Return checkpoint narrow / execution resume aligned';

        case 'Prepared but not yet executed':
            return 'Return checkpoint narrow / prepared resume aligned';

        case 'Timed for later finish':
            return 'Return checkpoint narrow / timed quiet hold';
    }

    return 'Return checkpoint narrow / conservative quiet return read';
}

public function getOwnerVisibleAcceptanceHandoffCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-visible acceptance handoff compression' => $this->owner_visible_acceptance_handoff_compression_label,
        'Quiet-lane return checkpoint alignment' => $this->quiet_lane_return_checkpoint_alignment_label,
        'Owner-tagged acceptance checkpoint compression' => $this->owner_tagged_acceptance_checkpoint_compression_label,
        'Quiet-lane return handoff framing' => $this->quiet_lane_return_handoff_framing_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-visible acceptance handoff compression digest is still minimal.');
}

public function getQuietLaneReturnCheckpointAlignmentFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-visible acceptance handoff compression: ' . $this->owner_visible_acceptance_handoff_compression_label . '.';
    $lines[] = 'Quiet-lane return checkpoint alignment: ' . $this->quiet_lane_return_checkpoint_alignment_label . '.';
    $lines[] = 'Owner-tagged acceptance checkpoint compression: ' . $this->owner_tagged_acceptance_checkpoint_compression_label . '.';
    $lines[] = 'Quiet-lane return handoff framing: ' . $this->quiet_lane_return_handoff_framing_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, acceptance handoff compression should collapse into active handling instead of quiet framing. The return checkpoint frame simply keeps the reopened control point readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, acceptance handoff compression cannot become truthful yet. The first real move is to assign the operator so the quiet-lane return checkpoint can stay credible across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one owner-visible acceptance handoff and one quiet-lane return checkpoint. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-visible acceptance handoff and one quiet-lane return checkpoint. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, acceptance handoff compression can stay calm and owner-visible before urgency rises. The return checkpoint frame keeps the next slot readable early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The acceptance handoff compression keeps the likely same-day move named, while the quiet-lane return checkpoint frame keeps the next control point aligned across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the acceptance handoff can stay compressed and parked. The return checkpoint frame exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, acceptance handoff compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one owner-visible acceptance handoff and one believable return checkpoint.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, acceptance handoff compression should keep the drafting move visibly attached to one owner. The quiet-lane return checkpoint frame keeps that likely move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, acceptance handoff compression should stay tied to the finish-choice control point. The quiet-lane return checkpoint frame keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, acceptance handoff compression should keep the next resume signal owner-visible. The quiet-lane return checkpoint frame makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, acceptance handoff compression stays conservative and scheduled. The quiet-lane return checkpoint frame simply keeps the eventual return control point visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-visible acceptance handoff compression and quiet-lane return checkpoint alignment remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getOwnerAlignedReturnCheckpointCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return compression active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return compression blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return compression aligned / overdue owner-aligned quiet return';

            case 'Due today':
                return 'Return compression aligned / same-day owner-aligned quiet return';

            case 'Due soon':
                return 'Return compression staged / next-slot owner-aligned quiet return';

            case 'Near-term':
                return 'Return compression staged / near-term owner-aligned quiet return';

            case 'Future':
                return 'Return compression parked / future owner-aligned quiet return';

            case 'Unscheduled':
                return 'Return compression open / set quiet checkpoint first';
        }

        return 'Return compression forming / owner-aligned quiet return readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return compression narrow / drafting return owner-aligned';

        case 'Closure packet prepared':
            return 'Return compression narrow / finish choice owner-aligned';

        case 'Execution still open':
            return 'Return compression narrow / execution resume owner-aligned';

        case 'Prepared but not yet executed':
            return 'Return compression narrow / prepared resume owner-aligned';

        case 'Timed for later finish':
            return 'Return compression narrow / later finish owner-aligned';
    }

    return 'Return compression narrow / conservative owner-aligned read';
}

public function getSameDayAcceptanceHandoffFramingLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Acceptance handoff active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Acceptance handoff blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Acceptance handoff framed / overdue same-day owner move';

            case 'Due today':
                return 'Acceptance handoff framed / same-day owner-visible handoff';

            case 'Due soon':
                return 'Acceptance handoff staged / next-slot same-day handoff';

            case 'Near-term':
                return 'Acceptance handoff staged / near-term same-day handoff';

            case 'Future':
                return 'Acceptance handoff parked / future same-day handoff';

            case 'Unscheduled':
                return 'Acceptance handoff open / set quiet checkpoint first';
        }

        return 'Acceptance handoff forming / same-day owner-visible move readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Acceptance handoff narrow / drafting move same-day framed';

        case 'Closure packet prepared':
            return 'Acceptance handoff narrow / finish choice same-day framed';

        case 'Execution still open':
            return 'Acceptance handoff narrow / execution resume same-day framed';

        case 'Prepared but not yet executed':
            return 'Acceptance handoff narrow / prepared resume same-day framed';

        case 'Timed for later finish':
            return 'Acceptance handoff narrow / later finish same-day framed';
    }

    return 'Acceptance handoff narrow / conservative same-day read';
}

public function getOwnerAlignedReturnCheckpointCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner-aligned return checkpoint compression' => $this->owner_aligned_return_checkpoint_compression_label,
        'Same-day acceptance handoff framing' => $this->same_day_acceptance_handoff_framing_label,
        'Owner-visible acceptance handoff compression' => $this->owner_visible_acceptance_handoff_compression_label,
        'Quiet-lane return checkpoint alignment' => $this->quiet_lane_return_checkpoint_alignment_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Owner-aligned return checkpoint compression digest is still minimal.');
}

public function getSameDayAcceptanceHandoffFramingFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner-aligned return checkpoint compression: ' . $this->owner_aligned_return_checkpoint_compression_label . '.';
    $lines[] = 'Same-day acceptance handoff framing: ' . $this->same_day_acceptance_handoff_framing_label . '.';
    $lines[] = 'Owner-visible acceptance handoff compression: ' . $this->owner_visible_acceptance_handoff_compression_label . '.';
    $lines[] = 'Quiet-lane return checkpoint alignment: ' . $this->quiet_lane_return_checkpoint_alignment_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, return checkpoint compression should collapse into active handling instead of quiet framing. The same-day acceptance handoff frame simply keeps the reopened owner move readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, return checkpoint compression cannot become truthful yet. The first real move is to assign the operator so the same-day acceptance handoff can be framed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one owner-aligned return checkpoint and one same-day acceptance handoff. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one owner-aligned return checkpoint and one same-day acceptance handoff. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, owner-aligned checkpoint compression can stay calm and readable before urgency rises. The same-day acceptance handoff frame keeps the next slot visible early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The checkpoint compression keeps the likely next return control point named, while the same-day acceptance handoff frame keeps the next owner move aligned across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the checkpoint compression can stay parked and owner-aligned. The same-day acceptance handoff frame exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, owner-aligned checkpoint compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one owner-aligned control point and one believable same-day handoff frame.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, return checkpoint compression should keep the drafting return visibly attached to one owner-aligned control point. The same-day acceptance handoff frame keeps that likely move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, return checkpoint compression should stay tied to the finish-choice control point. The same-day acceptance handoff frame keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, return checkpoint compression should keep the next resume signal owner-aligned. The same-day acceptance handoff frame makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, return checkpoint compression stays conservative and scheduled. The same-day acceptance handoff frame simply keeps the eventual owner move visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, owner-aligned return checkpoint compression and same-day acceptance handoff framing remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getReturnCheckpointHandoffCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return handoff active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return handoff blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return handoff aligned / overdue owner-visible quiet return';

            case 'Due today':
                return 'Return handoff aligned / same-day owner-visible quiet return';

            case 'Due soon':
                return 'Return handoff staged / next-slot owner-visible quiet return';

            case 'Near-term':
                return 'Return handoff staged / near-term owner-visible quiet return';

            case 'Future':
                return 'Return handoff parked / future owner-visible quiet return';

            case 'Unscheduled':
                return 'Return handoff open / set quiet checkpoint first';
        }

        return 'Return handoff forming / owner-visible quiet return readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return handoff narrow / drafting return owner-visible';

        case 'Closure packet prepared':
            return 'Return handoff narrow / finish choice owner-visible';

        case 'Execution still open':
            return 'Return handoff narrow / execution resume owner-visible';

        case 'Prepared but not yet executed':
            return 'Return handoff narrow / prepared resume owner-visible';

        case 'Timed for later finish':
            return 'Return handoff narrow / later finish owner-visible';
    }

    return 'Return handoff narrow / conservative owner-visible read';
}

public function getOwnerVisibleSameDayAcceptanceAlignmentLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Acceptance alignment active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Acceptance alignment blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Acceptance alignment framed / overdue same-day owner move';

            case 'Due today':
                return 'Acceptance alignment framed / same-day owner-visible handoff';

            case 'Due soon':
                return 'Acceptance alignment staged / next-slot same-day handoff';

            case 'Near-term':
                return 'Acceptance alignment staged / near-term same-day handoff';

            case 'Future':
                return 'Acceptance alignment parked / future same-day handoff';

            case 'Unscheduled':
                return 'Acceptance alignment open / set quiet checkpoint first';
        }

        return 'Acceptance alignment forming / same-day owner-visible move readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Acceptance alignment narrow / drafting move same-day framed';

        case 'Closure packet prepared':
            return 'Acceptance alignment narrow / finish choice same-day framed';

        case 'Execution still open':
            return 'Acceptance alignment narrow / execution resume same-day framed';

        case 'Prepared but not yet executed':
            return 'Acceptance alignment narrow / prepared resume same-day framed';

        case 'Timed for later finish':
            return 'Acceptance alignment narrow / later finish same-day framed';
    }

    return 'Acceptance alignment narrow / conservative same-day read';
}

public function getReturnCheckpointHandoffCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Return checkpoint handoff compression' => $this->return_checkpoint_handoff_compression_label,
        'Owner-visible same-day acceptance alignment' => $this->owner_visible_same_day_acceptance_alignment_label,
        'Owner-aligned return checkpoint compression' => $this->owner_aligned_return_checkpoint_compression_label,
        'Same-day acceptance handoff framing' => $this->same_day_acceptance_handoff_framing_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Return checkpoint handoff compression digest is still minimal.');
}

public function getOwnerVisibleSameDayAcceptanceAlignmentFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Return checkpoint handoff compression: ' . $this->return_checkpoint_handoff_compression_label . '.';
    $lines[] = 'Owner-visible same-day acceptance alignment: ' . $this->owner_visible_same_day_acceptance_alignment_label . '.';
    $lines[] = 'Owner-aligned return checkpoint compression: ' . $this->owner_aligned_return_checkpoint_compression_label . '.';
    $lines[] = 'Same-day acceptance handoff framing: ' . $this->same_day_acceptance_handoff_framing_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, return checkpoint handoff compression should collapse into active handling instead of quiet framing. The owner-visible same-day acceptance alignment simply keeps the reopened owner move readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, return checkpoint handoff compression cannot become truthful yet. The first real move is to assign the operator so the owner-visible same-day acceptance alignment can be framed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one return checkpoint handoff and one owner-visible same-day acceptance alignment. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one return checkpoint handoff and one owner-visible same-day acceptance alignment. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, return checkpoint handoff compression can stay calm and readable before urgency rises. The owner-visible same-day acceptance alignment keeps the next slot visible early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The return checkpoint handoff keeps the likely next quiet return move named, while the owner-visible same-day acceptance alignment keeps that owner move readable across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, the return checkpoint handoff can stay parked and owner-visible. The same-day acceptance alignment exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, return checkpoint handoff compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one believable handoff and one readable same-day acceptance alignment.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, return checkpoint handoff compression should keep the drafting return visibly attached to one owner-visible control point. The owner-visible same-day acceptance alignment keeps that likely move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, return checkpoint handoff compression should stay tied to the finish-choice control point. The owner-visible same-day acceptance alignment keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, return checkpoint handoff compression should keep the next resume signal owner-visible. The same-day acceptance alignment makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, return checkpoint handoff compression stays conservative and scheduled. The owner-visible same-day acceptance alignment simply keeps the eventual owner move visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, return checkpoint handoff compression and owner-visible same-day acceptance alignment remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}



public function getAcceptanceAlignmentCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Acceptance compression active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Acceptance compression blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Acceptance compression framed / overdue same-day owner move';

            case 'Due today':
                return 'Acceptance compression framed / same-day owner confirmation';

            case 'Due soon':
                return 'Acceptance compression staged / next-slot same-day confirmation';

            case 'Near-term':
                return 'Acceptance compression staged / near-term same-day confirmation';

            case 'Future':
                return 'Acceptance compression parked / future same-day confirmation';

            case 'Unscheduled':
                return 'Acceptance compression open / set quiet checkpoint first';
        }

        return 'Acceptance compression forming / same-day owner move readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Acceptance compression narrow / drafting move same-day framed';

        case 'Closure packet prepared':
            return 'Acceptance compression narrow / finish choice same-day framed';

        case 'Execution still open':
            return 'Acceptance compression narrow / execution resume same-day framed';

        case 'Prepared but not yet executed':
            return 'Acceptance compression narrow / prepared resume same-day framed';

        case 'Timed for later finish':
            return 'Acceptance compression narrow / later finish same-day framed';
    }

    return 'Acceptance compression narrow / conservative same-day read';
}

public function getQuietLaneReturnHandoffConfirmationLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return confirmation active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return confirmation blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return confirmation framed / overdue quiet handoff due';

            case 'Due today':
                return 'Return confirmation framed / same-day quiet handoff due';

            case 'Due soon':
                return 'Return confirmation staged / near-slot quiet handoff';

            case 'Near-term':
                return 'Return confirmation staged / near-term quiet handoff';

            case 'Future':
                return 'Return confirmation parked / future quiet handoff';

            case 'Unscheduled':
                return 'Return confirmation open / set quiet checkpoint first';
        }

        return 'Return confirmation forming / quiet handoff readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return confirmation narrow / drafting return owner-visible';

        case 'Closure packet prepared':
            return 'Return confirmation narrow / finish choice owner-visible';

        case 'Execution still open':
            return 'Return confirmation narrow / execution resume owner-visible';

        case 'Prepared but not yet executed':
            return 'Return confirmation narrow / prepared resume owner-visible';

        case 'Timed for later finish':
            return 'Return confirmation narrow / later finish owner-visible';
    }

    return 'Return confirmation narrow / conservative quiet return read';
}

public function getAcceptanceAlignmentCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Acceptance alignment compression' => $this->acceptance_alignment_compression_label,
        'Quiet-lane return handoff confirmation' => $this->quiet_lane_return_handoff_confirmation_label,
        'Return checkpoint handoff compression' => $this->return_checkpoint_handoff_compression_label,
        'Owner-visible same-day acceptance alignment' => $this->owner_visible_same_day_acceptance_alignment_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Acceptance alignment compression digest is still minimal.');
}

public function getQuietLaneReturnHandoffConfirmationFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Acceptance alignment compression: ' . $this->acceptance_alignment_compression_label . '.';
    $lines[] = 'Quiet-lane return handoff confirmation: ' . $this->quiet_lane_return_handoff_confirmation_label . '.';
    $lines[] = 'Return checkpoint handoff compression: ' . $this->return_checkpoint_handoff_compression_label . '.';
    $lines[] = 'Owner-visible same-day acceptance alignment: ' . $this->owner_visible_same_day_acceptance_alignment_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, acceptance alignment compression should collapse into active handling instead of quiet framing. The quiet-lane return handoff confirmation simply keeps the reopened owner move readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, acceptance alignment compression cannot become truthful yet. The first real move is to assign the operator so the quiet-lane return handoff confirmation can be framed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one acceptance alignment compression cue and one quiet-lane return handoff confirmation cue. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one acceptance alignment compression cue and one quiet-lane return handoff confirmation cue. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, acceptance alignment compression can stay calm and readable before urgency rises. The quiet-lane return handoff confirmation keeps the next slot visible early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The acceptance alignment compression keeps the likely same-day move named, while the quiet-lane return handoff confirmation keeps that quiet return readable across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, acceptance alignment compression can stay parked and owner-visible. The quiet-lane return handoff confirmation exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, acceptance alignment compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one believable confirmation and one readable same-day alignment cue.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, acceptance alignment compression should keep the drafting move visibly attached to one owner-visible control point. The quiet-lane return handoff confirmation keeps that likely return move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, acceptance alignment compression should stay tied to the finish-choice control point. The quiet-lane return handoff confirmation keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, acceptance alignment compression should keep the next resume signal owner-visible. The quiet-lane return handoff confirmation makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, acceptance alignment compression stays conservative and scheduled. The quiet-lane return handoff confirmation simply keeps the eventual owner move visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, acceptance alignment compression and quiet-lane return handoff confirmation remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}

public function getAcceptanceConfirmationCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Acceptance confirmation active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Acceptance confirmation blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Acceptance confirmation framed / overdue same-day owner move';

            case 'Due today':
                return 'Acceptance confirmation framed / same-day owner checkpoint';

            case 'Due soon':
                return 'Acceptance confirmation staged / next-slot same-day checkpoint';

            case 'Near-term':
                return 'Acceptance confirmation staged / near-term same-day checkpoint';

            case 'Future':
                return 'Acceptance confirmation parked / future same-day checkpoint';

            case 'Unscheduled':
                return 'Acceptance confirmation open / set quiet checkpoint first';
        }

        return 'Acceptance confirmation forming / same-day owner checkpoint readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Acceptance confirmation narrow / drafting move same-day framed';

        case 'Closure packet prepared':
            return 'Acceptance confirmation narrow / finish choice same-day framed';

        case 'Execution still open':
            return 'Acceptance confirmation narrow / execution resume same-day framed';

        case 'Prepared but not yet executed':
            return 'Acceptance confirmation narrow / prepared resume same-day framed';

        case 'Timed for later finish':
            return 'Acceptance confirmation narrow / later finish same-day framed';
    }

    return 'Acceptance confirmation narrow / conservative same-day read';
}

public function getQuietLaneReturnCheckpointConfirmationLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return checkpoint confirmation active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return checkpoint confirmation blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return checkpoint confirmation framed / overdue quiet checkpoint due';

            case 'Due today':
                return 'Return checkpoint confirmation framed / same-day quiet checkpoint due';

            case 'Due soon':
                return 'Return checkpoint confirmation staged / near-slot quiet checkpoint';

            case 'Near-term':
                return 'Return checkpoint confirmation staged / near-term quiet checkpoint';

            case 'Future':
                return 'Return checkpoint confirmation parked / future quiet checkpoint';

            case 'Unscheduled':
                return 'Return checkpoint confirmation open / set quiet checkpoint first';
        }

        return 'Return checkpoint confirmation forming / quiet checkpoint readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return checkpoint confirmation narrow / drafting return owner-visible';

        case 'Closure packet prepared':
            return 'Return checkpoint confirmation narrow / finish choice owner-visible';

        case 'Execution still open':
            return 'Return checkpoint confirmation narrow / execution resume owner-visible';

        case 'Prepared but not yet executed':
            return 'Return checkpoint confirmation narrow / prepared resume owner-visible';

        case 'Timed for later finish':
            return 'Return checkpoint confirmation narrow / later finish owner-visible';
    }

    return 'Return checkpoint confirmation narrow / conservative quiet return read';
}

public function getAcceptanceConfirmationCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Acceptance confirmation compression' => $this->acceptance_confirmation_compression_label,
        'Quiet-lane return checkpoint confirmation' => $this->quiet_lane_return_checkpoint_confirmation_label,
        'Acceptance alignment compression' => $this->acceptance_alignment_compression_label,
        'Quiet-lane return handoff confirmation' => $this->quiet_lane_return_handoff_confirmation_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Acceptance confirmation compression digest is still minimal.');
}

public function getQuietLaneReturnCheckpointConfirmationFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Acceptance confirmation compression: ' . $this->acceptance_confirmation_compression_label . '.';
    $lines[] = 'Quiet-lane return checkpoint confirmation: ' . $this->quiet_lane_return_checkpoint_confirmation_label . '.';
    $lines[] = 'Acceptance alignment compression: ' . $this->acceptance_alignment_compression_label . '.';
    $lines[] = 'Quiet-lane return handoff confirmation: ' . $this->quiet_lane_return_handoff_confirmation_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, acceptance confirmation compression should collapse into active handling instead of quiet framing. The quiet-lane return checkpoint confirmation simply keeps the reopened owner move readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, acceptance confirmation compression cannot become truthful yet. The first real move is to assign the operator so the quiet-lane return checkpoint confirmation can be framed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one acceptance confirmation compression cue and one quiet-lane return checkpoint confirmation cue. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one acceptance confirmation compression cue and one quiet-lane return checkpoint confirmation cue. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, acceptance confirmation compression can stay calm and readable before urgency rises. The quiet-lane return checkpoint confirmation keeps the next slot visible early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The acceptance confirmation compression keeps the likely same-day move named, while the quiet-lane return checkpoint confirmation keeps that quiet return readable across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, acceptance confirmation compression can stay parked and owner-visible. The quiet-lane return checkpoint confirmation exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, acceptance confirmation compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one believable confirmation and one readable same-day checkpoint cue.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, acceptance confirmation compression should keep the drafting move visibly attached to one owner-visible control point. The quiet-lane return checkpoint confirmation keeps that likely return move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, acceptance confirmation compression should stay tied to the finish-choice control point. The quiet-lane return checkpoint confirmation keeps that prepared move narrow, readable, and easy to confirm across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, acceptance confirmation compression should keep the next resume signal owner-visible. The quiet-lane return checkpoint confirmation makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, acceptance confirmation compression stays conservative and scheduled. The quiet-lane return checkpoint confirmation simply keeps the eventual owner move visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, acceptance confirmation compression and quiet-lane return checkpoint confirmation remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getAcceptanceConfirmationHandoffCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Acceptance confirmation handoff active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Acceptance confirmation handoff blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Acceptance confirmation handoff framed / overdue owner handoff due';

            case 'Due today':
                return 'Acceptance confirmation handoff framed / same-day owner handoff';

            case 'Due soon':
                return 'Acceptance confirmation handoff staged / next-slot owner handoff';

            case 'Near-term':
                return 'Acceptance confirmation handoff staged / near-term owner handoff';

            case 'Future':
                return 'Acceptance confirmation handoff parked / future owner handoff';

            case 'Unscheduled':
                return 'Acceptance confirmation handoff open / set owner checkpoint first';
        }

        return 'Acceptance confirmation handoff forming / owner handoff readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Acceptance confirmation handoff narrow / drafting handoff owner-visible';

        case 'Closure packet prepared':
            return 'Acceptance confirmation handoff narrow / finish choice handoff owner-visible';

        case 'Execution still open':
            return 'Acceptance confirmation handoff narrow / execution resume handoff owner-visible';

        case 'Prepared but not yet executed':
            return 'Acceptance confirmation handoff narrow / prepared resume handoff owner-visible';

        case 'Timed for later finish':
            return 'Acceptance confirmation handoff narrow / later finish handoff owner-visible';
    }

    return 'Acceptance confirmation handoff narrow / conservative owner handoff read';
}

public function getQuietLaneReturnCheckpointFrameCueLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Return checkpoint framing active / reopened lane already visible';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Return checkpoint framing blocked / assign owner first';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Return checkpoint framing framed / overdue quiet checkpoint due';

            case 'Due today':
                return 'Return checkpoint framing framed / same-day quiet checkpoint due';

            case 'Due soon':
                return 'Return checkpoint framing staged / near-slot quiet checkpoint';

            case 'Near-term':
                return 'Return checkpoint framing staged / near-term quiet checkpoint';

            case 'Future':
                return 'Return checkpoint framing parked / future quiet checkpoint';

            case 'Unscheduled':
                return 'Return checkpoint framing open / set quiet checkpoint first';
        }

        return 'Return checkpoint framing forming / quiet checkpoint readable';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Return checkpoint framing narrow / drafting return owner-visible';

        case 'Closure packet prepared':
            return 'Return checkpoint framing narrow / finish choice return owner-visible';

        case 'Execution still open':
            return 'Return checkpoint framing narrow / execution resume return owner-visible';

        case 'Prepared but not yet executed':
            return 'Return checkpoint framing narrow / prepared resume return owner-visible';

        case 'Timed for later finish':
            return 'Return checkpoint framing narrow / later finish return owner-visible';
    }

    return 'Return checkpoint framing narrow / conservative quiet return read';
}

public function getAcceptanceConfirmationHandoffCompressionDigestAttribute(): string
{
    return $this->formatSummary([
        'Acceptance confirmation handoff compression' => $this->acceptance_confirmation_handoff_compression_label,
        'Quiet-lane return checkpoint framing' => $this->quiet_lane_return_checkpoint_frame_cue_label,
        'Acceptance confirmation compression' => $this->acceptance_confirmation_compression_label,
        'Quiet-lane return checkpoint confirmation' => $this->quiet_lane_return_checkpoint_confirmation_label,
        'Next review window' => $this->next_review_window_label,
        'Quiet-lane return' => $this->quiet_lane_return_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
    ], 'Acceptance confirmation handoff compression digest is still minimal.');
}

public function getQuietLaneReturnCheckpointFrameCueFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Acceptance confirmation handoff compression: ' . $this->acceptance_confirmation_handoff_compression_label . '.';
    $lines[] = 'Quiet-lane return checkpoint framing: ' . $this->quiet_lane_return_checkpoint_frame_cue_label . '.';
    $lines[] = 'Acceptance confirmation compression: ' . $this->acceptance_confirmation_compression_label . '.';
    $lines[] = 'Quiet-lane return checkpoint confirmation: ' . $this->quiet_lane_return_checkpoint_confirmation_label . '.';
    $lines[] = 'Next review window: ' . $this->next_review_window_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, acceptance confirmation handoff compression should collapse into active handling instead of quiet framing. The quiet-lane return checkpoint framing simply keeps the reopened owner move readable across the loyalty list, overview workspace, and linked inquiry snapshot.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the record is already in an immediate review window but still has no named owner, acceptance confirmation handoff compression cannot become truthful yet. The first real move is to assign the operator so the quiet-lane return checkpoint framing can be framed credibly across every surface.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane return is overdue, the workspace should compress into one acceptance confirmation handoff compression cue and one quiet-lane return checkpoint framing cue. That keeps the overdue move readable now without widening the workflow or inventing automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the return is due today, the workspace should read as one acceptance confirmation handoff compression cue and one quiet-lane return checkpoint framing cue. That gives the list, overview, and linked inquiry snapshot the same narrow operator signal.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the return is due soon, acceptance confirmation handoff compression can stay calm and readable before urgency rises. The quiet-lane return checkpoint framing keeps the next slot visible early without overstating pressure.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the return is near-term, the workspace can stay conservative and owner-led. The acceptance confirmation handoff compression keeps the likely same-day owner move named, while the quiet-lane return checkpoint framing keeps that quiet return readable across every surface.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the return still belongs to a future quiet window, acceptance confirmation handoff compression can stay parked and owner-visible. The quiet-lane return checkpoint framing exists so the later move remains understandable without pretending it belongs in an active lane.';
        } else {
            $lines[] = 'Because the return still lacks a usable slot, acceptance confirmation handoff compression cannot finish yet. The next human move is to set a real checkpoint so the quiet-lane return can compress into one believable handoff cue and one readable checkpoint framing cue.';
        }
    } elseif ($this->closure_readiness_label === 'Ready for finish packet') {
        $lines[] = 'Because the record is ready for close drafting, acceptance confirmation handoff compression should keep the drafting move visibly attached to one owner-visible control point. The quiet-lane return checkpoint framing keeps that likely return move explicit without reopening a wider queue story.';
    } elseif ($this->closure_readiness_label === 'Closure packet prepared') {
        $lines[] = 'Because a close packet is already prepared, acceptance confirmation handoff compression should stay tied to the finish-choice control point. The quiet-lane return checkpoint framing keeps that prepared move narrow, readable, and easy to frame across list, overview, and inquiry surfaces.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because close-side execution still needs a deliberate operator move, acceptance confirmation handoff compression should keep the next resume signal owner-visible. The quiet-lane return checkpoint framing makes that resume posture easier to scan without changing the underlying workflow.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, acceptance confirmation handoff compression stays conservative and scheduled. The quiet-lane return checkpoint framing simply keeps the eventual owner move visible without overstating urgency.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, acceptance confirmation handoff compression and quiet-lane return checkpoint framing remain narrow human scan aids only. They reduce translation between list, overview, and inquiry surfaces without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getQueueScanPrioritizationCueLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'P1 / reopened proof review now';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'P1 / assign owner and review now';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'P1 / quiet checkpoint overdue';

            case 'Due today':
                return 'P1 / quiet checkpoint today';

            case 'Due soon':
                return 'P2 / quiet checkpoint due soon';

            case 'Near-term':
                return 'P3 / quiet checkpoint near-term';

            case 'Future':
                return 'P4 / future quiet checkpoint';

            case 'Unscheduled':
                return 'P2 / quiet checkpoint missing';
        }

        return 'P3 / quiet checkpoint forming';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'P2 / finish packet decision';

        case 'Closure packet prepared':
            return 'P2 / finish choice checkpoint';

        case 'Execution still open':
            return 'P2 / execution follow-through';

        case 'Prepared but not yet executed':
            return 'P2 / prepared follow-through';

        case 'Timed for later finish':
            return 'P4 / timed finish watch';
    }

    if (in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'P1 / review window due';
    }

    if ($this->next_review_window_label === 'Due soon') {
        return 'P2 / review window due soon';
    }

    if ($this->next_review_at) {
        return 'P3 / review slot scheduled';
    }

    return 'P4 / quiet human watch';
}

public function getHumanReviewTimingClarityLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return trim((string) $this->owner_name) === ''
            ? 'Review now / assign owner immediately'
            : 'Review now / reopened lane is live';
    }

    if (!$this->next_review_at) {
        return trim((string) $this->owner_name) === ''
            ? 'Timing open / assign owner and set checkpoint'
            : 'Timing open / set next human checkpoint';
    }

    switch ($this->next_review_window_label) {
        case 'Overdue':
            return trim((string) $this->owner_name) === ''
                ? 'Review now / overdue and owner missing'
                : 'Review now / overdue checkpoint';

        case 'Due today':
            return trim((string) $this->owner_name) === ''
                ? 'Review this shift / assign owner first'
                : 'Review this shift / same-day checkpoint';

        case 'Due soon':
            return 'Review soon / next 3 days';

        case 'Near-term':
            return 'Review queued / next 14 days';

        case 'Future':
            return 'Review later / future quiet slot';

        default:
            return 'Review timing forming / checkpoint still settling';
    }
}

public function getQueueScanPrioritizationCueDigestAttribute(): string
{
    return $this->formatSummary([
        'Queue priority' => $this->queue_scan_prioritization_cue_label,
        'Review timing' => $this->human_review_timing_clarity_label,
        'Handoff compression' => $this->acceptance_confirmation_handoff_compression_label,
        'Checkpoint frame' => $this->quiet_lane_return_checkpoint_frame_cue_label,
        'Queue watch' => $this->queue_watch_readiness_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Queue-scan prioritization digest is still minimal.');
}

public function getHumanReviewTimingClarityFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Queue priority: ' . $this->queue_scan_prioritization_cue_label . '.';
    $lines[] = 'Review timing: ' . $this->human_review_timing_clarity_label . '.';
    $lines[] = 'Handoff compression: ' . $this->acceptance_confirmation_handoff_compression_label . '.';
    $lines[] = 'Checkpoint frame: ' . $this->quiet_lane_return_checkpoint_frame_cue_label . '.';
    $lines[] = 'Queue watch: ' . $this->queue_watch_readiness_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, this record should rise to the top of the human queue immediately. The timing cue exists to remove hesitation: review the reopened lane now, and assign a named owner first if one is still missing.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the checkpoint is already due but no owner is named yet, the queue priority must stay high. The first real move is not another compression pass; it is to assign ownership so the review timing can remain credible across the list, overview, and linked inquiry snapshot.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the quiet-lane checkpoint is overdue, this record should surface as a P1 review now item. The timing cue keeps the return checkpoint human and immediate without widening the workflow into automation.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the quiet-lane checkpoint lands today, this record should stay near the top of the queue for the current shift. The timing cue keeps the same-day review explicit so the operator does not have to re-translate the quieter loyalty signals.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet-lane checkpoint is due soon, the record should remain visible but not noisy. The timing cue keeps the next three-day window readable early without pretending that the record already belongs in an immediate lane.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the review window is near-term, the workspace can stay conservative and scheduled. The queue priority remains moderate while the timing cue keeps the upcoming checkpoint easy to spot during routine human scans.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the review window still belongs to a future quiet slot, this record can stay lower in the queue without disappearing. The timing cue protects that later checkpoint from being forgotten while keeping the current lane calm.';
        } else {
            $lines[] = 'Because a parked quiet-lane checkpoint still has no usable date, the queue priority must stay moderately elevated until a real human checkpoint is set. The timing cue exists so the missing slot is visible immediately.';
        }
    } elseif (in_array($this->closure_readiness_label, ['Ready for finish packet', 'Closure packet prepared'], true)) {
        $lines[] = 'Because the finish posture is already commercially mature, this record belongs in a deliberate decision queue rather than a vague background watch. The timing cue keeps the next human checkpoint explicit so prepared work does not drift.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because follow-through execution is still open, this record should remain above passive watch items until the loop closes or timing is deliberately deferred. The timing cue tells the operator whether that move is now, soon, or already scheduled.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, the queue priority can stay low and the human checkpoint can remain scheduled. The timing cue exists to protect that deliberate later move without adding pressure or automation.';
    } else {
        $lines[] = 'Because the workspace is still quiet and conservative, queue priority and review timing should stay narrow human scan aids only. They compress the final translation from loyalty posture into operator action without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}



public function getOwnerReviewSlotSequenceLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return '01 · owner review now / reopened evidence lane';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return '01 · assign owner now / due review cannot sequence';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return '01 · overdue owner checkpoint / first review pass';

            case 'Due today':
                return '02 · same-day owner checkpoint / this-shift review';

            case 'Due soon':
                return '03 · upcoming owner checkpoint / pre-read queue';

            case 'Near-term':
                return '04 · near-term owner checkpoint / keep sequence visible';

            case 'Future':
                return '05 · future owner checkpoint / leave parked';

            case 'Unscheduled':
                return '02 · owner sequence blocked / set checkpoint date';
        }

        return '04 · owner review sequence / quiet lane still forming';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return '03 · drafting owner checkpoint / review soon';

        case 'Closure packet prepared':
            return '03 · finish-choice owner checkpoint / review soon';

        case 'Execution still open':
            return '02 · execution owner checkpoint / reopen early';

        case 'Prepared but not yet executed':
            return '03 · prepared owner checkpoint / resume deliberately';

        case 'Timed for later finish':
            return '05 · timed finish checkpoint / review on schedule';
    }

    return '06 · conservative owner sequence / background review';
}

public function getQueueBacklogVisibilityLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Top backlog / reopened evidence waiting';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Top backlog / due work still unowned';
    }

    if ($this->latest_finish_lane_mode !== '') {
        switch ($this->next_review_window_label) {
            case 'Overdue':
                return 'Front backlog / overdue parked checkpoint';

            case 'Due today':
                return 'Front backlog / same-day parked checkpoint';

            case 'Due soon':
                return 'Visible backlog / next 3 days';

            case 'Near-term':
                return 'Visible backlog / next 14 days';

            case 'Future':
                return 'Deep backlog / future quiet slot';

            case 'Unscheduled':
                return 'Visible backlog / checkpoint timing missing';
        }

        return 'Standard backlog / quiet-lane backlog forming';
    }

    switch ($this->closure_readiness_label) {
        case 'Ready for finish packet':
            return 'Visible backlog / finish drafting decision';

        case 'Closure packet prepared':
            return 'Visible backlog / prepared close decision';

        case 'Execution still open':
            return 'Front backlog / follow-through not closed';

        case 'Prepared but not yet executed':
            return 'Visible backlog / prepared work waiting';

        case 'Timed for later finish':
            return 'Deep backlog / intentionally scheduled finish';
    }

    return 'Standard backlog / conservative review watch';
}

public function getOwnerReviewSlotSequenceDigestAttribute(): string
{
    return $this->formatSummary([
        'Owner review sequence' => $this->owner_review_slot_sequence_label,
        'Queue backlog visibility' => $this->queue_backlog_visibility_label,
        'Queue priority' => $this->queue_scan_prioritization_cue_label,
        'Review timing' => $this->human_review_timing_clarity_label,
        'Quiet-lane review slot' => $this->quiet_lane_review_slot_label,
        'Re-entry order' => $this->quiet_lane_reentry_order_label,
        'Owner timing signal' => $this->owner_timing_signal_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Owner review-slot sequence digest is still minimal.');
}

public function getQueueBacklogVisibilityFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Owner review sequence: ' . $this->owner_review_slot_sequence_label . '.';
    $lines[] = 'Queue backlog visibility: ' . $this->queue_backlog_visibility_label . '.';
    $lines[] = 'Queue priority: ' . $this->queue_scan_prioritization_cue_label . '.';
    $lines[] = 'Review timing: ' . $this->human_review_timing_clarity_label . '.';
    $lines[] = 'Quiet-lane review slot: ' . $this->quiet_lane_review_slot_label . '.';
    $lines[] = 'Re-entry order: ' . $this->quiet_lane_reentry_order_label . '.';
    $lines[] = 'Owner timing signal: ' . $this->owner_timing_signal_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, this record should lead the human backlog immediately. The sequence cue removes ambiguity about who should read it first, and the backlog cue makes sure the reopened evidence lane does not sink back into quiet parking.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because the checkpoint is already due but no owner is named, backlog visibility must stay at the front until assignment happens. The first real move is to assign ownership so the sequence becomes truthful across the list, overview, and linked inquiry snapshot.';
    } elseif ($this->latest_finish_lane_mode !== '') {
        if ($this->next_review_window_label === 'Overdue') {
            $lines[] = 'Because the parked quiet-lane checkpoint is overdue, this record belongs at the front of the backlog and at the first owner review slot. The goal is not automation; it is to make the overdue human read unmistakable.';
        } elseif ($this->next_review_window_label === 'Due today') {
            $lines[] = 'Because the parked checkpoint lands today, this record should stay in the front backlog for the current shift. The sequence cue keeps the owner review order narrow and same-day readable without widening the workflow.';
        } elseif ($this->next_review_window_label === 'Due soon') {
            $lines[] = 'Because the quiet checkpoint is due soon, the record should remain visibly staged without crowding out immediate items. The backlog cue keeps it on board early so the owner can pre-read the next slot deliberately.';
        } elseif ($this->next_review_window_label === 'Near-term') {
            $lines[] = 'Because the checkpoint sits in a near-term window, the record can remain in the visible backlog instead of the front edge. The sequence cue simply keeps the next owner pass obvious during routine queue scans.';
        } elseif ($this->next_review_window_label === 'Future') {
            $lines[] = 'Because the checkpoint still belongs to a future quiet slot, the record can sit deeper in the backlog while staying explicitly parked. The sequence cue protects the later owner pass from vanishing into background ambiguity.';
        } else {
            $lines[] = 'Because the checkpoint timing is still unclear, backlog visibility should stay elevated until a real date is named. The sequence cue exists so the missing owner checkpoint is obvious during human review.';
        }
    } elseif (in_array($this->closure_readiness_label, ['Ready for finish packet', 'Closure packet prepared'], true)) {
        $lines[] = 'Because the record is already close-ready, backlog visibility should stay deliberate rather than passive. The sequence cue keeps the next owner decision in sight so prepared finish work does not drift behind quieter records.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because execution is still open, this record belongs ahead of passive background review. The backlog cue tells the operator it is still waiting for follow-through, and the sequence cue keeps the next owner pass readable.';
    } elseif ($this->closure_readiness_label === 'Timed for later finish') {
        $lines[] = 'Because later finish timing is intentional, the record can sit deeper in the backlog without disappearing. The sequence cue simply protects the scheduled owner pass without adding artificial urgency.';
    } else {
        $lines[] = 'Because the workspace remains quiet and conservative, owner sequence and backlog visibility stay narrow human scan aids only. They help the queue read in one pass without changing the underlying workflow.';
    }

    return implode(PHP_EOL, $lines);
}


public function getSameShiftHandoffSequenceLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Immediate same-shift handoff / reopened evidence first';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Unowned same-shift handoff / assign before shift close';
    }

    if ($this->next_review_window_label === 'Overdue') {
        return 'First same-shift handoff / overdue checkpoint leads';
    }

    if ($this->next_review_window_label === 'Due today') {
        return 'Current-shift handoff / same-day checkpoint stays visible';
    }

    if ($this->next_review_window_label === 'Due soon') {
        return 'Same-shift preview handoff / next slot staged early';
    }

    if ($this->next_review_window_label === 'Near-term') {
        return 'Later-shift handoff / visible but not first';
    }

    if ($this->next_review_window_label === 'Future') {
        return 'Deferred shift handoff / future quiet slot remains parked';
    }

    if ($this->next_review_window_label === 'Unscheduled') {
        return 'Unclear shift handoff / timing still needs naming';
    }

    if (in_array($this->closure_readiness_label, ['Ready for finish packet', 'Closure packet prepared'], true)) {
        return 'Decision handoff / finish-ready record stays in sequence';
    }

    if (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        return 'Follow-through handoff / open execution remains on shift';
    }

    if ($this->closure_readiness_label === 'Timed for later finish') {
        return 'Scheduled handoff / later finish window preserved';
    }

    return 'Background handoff / conservative same-shift review';
}

public function getQueueBacklogCompressionLabelAttribute(): string
{
    if ($this->latest_finish_lane_state === 'reopened') {
        return 'Minimal compression / reopened record fully surfaced';
    }

    if (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        return 'Low compression / due work stays visible until assigned';
    }

    if (strpos($this->queue_backlog_visibility_label, 'Front backlog') === 0 || strpos($this->queue_backlog_visibility_label, 'Top backlog') === 0) {
        return 'Light compression / front backlog kept readable';
    }

    if (strpos($this->queue_backlog_visibility_label, 'Visible backlog') === 0) {
        return 'Moderate compression / staged backlog stays scanable';
    }

    if (strpos($this->queue_backlog_visibility_label, 'Deep backlog') === 0) {
        return 'High compression / deeper parked backlog preserved';
    }

    if (strpos($this->queue_backlog_visibility_label, 'Standard backlog') === 0) {
        return 'Balanced compression / conservative backlog read';
    }

    if (in_array($this->closure_readiness_label, ['Ready for finish packet', 'Closure packet prepared'], true)) {
        return 'Moderate compression / prepared finish work still visible';
    }

    if (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        return 'Light compression / execution follow-through near front';
    }

    return 'Balanced compression / narrow queue compression';
}

public function getSameShiftHandoffSequenceDigestAttribute(): string
{
    return $this->formatSummary([
        'Same-shift handoff' => $this->same_shift_handoff_sequence_label,
        'Backlog compression' => $this->queue_backlog_compression_label,
        'Owner review sequence' => $this->owner_review_slot_sequence_label,
        'Queue backlog visibility' => $this->queue_backlog_visibility_label,
        'Queue priority' => $this->queue_scan_prioritization_cue_label,
        'Review timing' => $this->human_review_timing_clarity_label,
        'Next review window' => $this->next_review_window_label,
    ], 'Same-shift handoff digest is still minimal.');
}

public function getQueueBacklogCompressionFrameAttribute(): string
{
    $lines = [];
    $lines[] = 'Same-shift handoff: ' . $this->same_shift_handoff_sequence_label . '.';
    $lines[] = 'Backlog compression: ' . $this->queue_backlog_compression_label . '.';
    $lines[] = 'Owner review sequence: ' . $this->owner_review_slot_sequence_label . '.';
    $lines[] = 'Queue backlog visibility: ' . $this->queue_backlog_visibility_label . '.';
    $lines[] = 'Queue priority: ' . $this->queue_scan_prioritization_cue_label . '.';
    $lines[] = 'Review timing: ' . $this->human_review_timing_clarity_label . '.';

    if ($this->latest_finish_lane_state === 'reopened') {
        $lines[] = 'Because the finish lane is already reopened, same-shift handoff should stay immediate and backlog compression should stay minimal. The record needs a clear current-shift read, not deeper parking.';
    } elseif (trim((string) $this->owner_name) === '' && in_array($this->next_review_window_label, ['Overdue', 'Due today'], true)) {
        $lines[] = 'Because a due checkpoint still lacks ownership, same-shift handoff should stay explicit and backlog compression should remain low. The next safe move is to name an owner before the record is allowed to sink into background backlog.';
    } elseif ($this->next_review_window_label === 'Overdue') {
        $lines[] = 'Because the checkpoint is overdue, the current shift should inherit it first and backlog compression should stay light. The purpose is one-pass queue reading, not workflow expansion.';
    } elseif ($this->next_review_window_label === 'Due today') {
        $lines[] = 'Because the checkpoint lands today, the record belongs in the current shift handoff and should remain lightly compressed in the visible front backlog. That keeps the same-day read obvious across the list, overview, and linked inquiry snapshot.';
    } elseif ($this->next_review_window_label === 'Due soon') {
        $lines[] = 'Because the checkpoint is due soon, the record can stay moderately compressed while still being pre-read during the current shift. The handoff cue exists so near-term work does not disappear behind quieter backlog lanes.';
    } elseif ($this->next_review_window_label === 'Near-term') {
        $lines[] = 'Because the checkpoint is near-term rather than immediate, the record can sit in a later shift handoff with moderate backlog compression. The cue keeps it staged without falsely promoting it above current-shift work.';
    } elseif ($this->next_review_window_label === 'Future') {
        $lines[] = 'Because the checkpoint belongs to a future quiet slot, backlog compression can stay higher while the deferred shift handoff remains explicit. The goal is to preserve visibility without crowding the front queue.';
    } elseif ($this->next_review_window_label === 'Unscheduled') {
        $lines[] = 'Because timing is still unscheduled, backlog compression should stay balanced and the handoff cue should keep the missing checkpoint obvious. The workspace stays human-led by surfacing uncertainty instead of inventing automation.';
    } elseif (in_array($this->closure_readiness_label, ['Ready for finish packet', 'Closure packet prepared'], true)) {
        $lines[] = 'Because finish work is already prepared, the record should stay in a decision handoff lane with moderate compression. It remains visible enough for the next owner pass without flattening the whole queue into one urgency band.';
    } elseif (in_array($this->closure_readiness_label, ['Execution still open', 'Prepared but not yet executed'], true)) {
        $lines[] = 'Because execution still needs follow-through, same-shift handoff should remain active and backlog compression should stay light. The record should be easy to find during the current operator pass.';
    } else {
        $lines[] = 'Because the workspace remains quiet and conservative, same-shift handoff and backlog compression stay narrow human scan aids only. They compress queue reading without changing the underlying inquiry workflow.';
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

    public function seedFromInquiry(Inquiry $inquiry, array $overrides = [], ?string $operatorName = null, bool $preserveExisting = true): void
    {
        if (!$inquiry || !$inquiry->id) {
            return;
        }

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

        $seed = [
            'source_inquiry_id'       => $inquiry->id,
            'request_reference'       => $inquiry->request_reference,
            'guest_name'              => $inquiry->full_name,
            'guest_email'             => $inquiry->email,
            'guest_phone'             => $inquiry->phone,
            'country'                 => $inquiry->country,
            'owner_name'              => $inquiry->owner_name ?: ($operatorName ?: 'Operator'),
            'service_focus_summary'   => $inquiry->services_inline ?: 'General planning',
            'source_summary'          => $sourceSummary !== '' ? $sourceSummary : 'Source context was limited on the originating inquiry.',
            'continuity_summary'      => $continuitySummary !== '' ? $continuitySummary : 'Inquiry continuity summary is still minimal.',
            'created_by'              => $operatorName ?: 'Operator',
            'continuity_status'       => 'active_retention',
            'loyalty_stage'           => 'review',
            'return_value_tier'       => 'watch',
            'return_value_candidate'  => false,
            'next_review_at'          => Carbon::now()->addDays(14),
        ];

        foreach ($overrides as $field => $value) {
            $seed[$field] = $value;
        }

        foreach ($seed as $field => $value) {
            if ($preserveExisting && $this->seedFieldHasMeaningfulValue($field, $this->{$field} ?? null)) {
                continue;
            }

            $this->{$field} = $value;
        }
    }

    protected function seedFieldHasMeaningfulValue(string $field, $value): bool
    {
        if ($value instanceof \DateTimeInterface) {
            return true;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_array($value)) {
            return !empty($value);
        }

        if (is_numeric($value)) {
            return (int) $value > 0;
        }

        return trim((string) $value) !== '';
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
