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
