<?php namespace Cabnet\MykonosInquiry\Models;

use Carbon\Carbon;
use Model;
use Schema;

class Inquiry extends Model
{
    public $table = 'cabnet_mykonos_inquiries';

    protected $guarded = ['id'];

    protected $dates = [
        'arrival_date',
        'departure_date',
        'follow_up_date',
        'last_contacted_at',
        'closed_at',
        'created_at',
        'updated_at',
    ];

    public $jsonable = ['services_json', 'payload_json'];

    public $hasMany = [
        'notes' => [InquiryNote::class, 'order' => 'created_at desc'],
    ];

    public $hasOne = [
        'loyalty_record' => [LoyaltyRecord::class, 'key' => 'source_inquiry_id'],
    ];

    protected array $workflowChanges = [];

    public function getStatusOptions(): array
    {
        return [
            'new' => 'New brief',
            'reviewed' => 'Reviewed',
            'contacted' => 'Contacted',
            'proposal_sent' => 'Proposal sent',
            'awaiting_guest' => 'Awaiting guest',
            'confirmed' => 'Confirmed',
            'closed_won' => 'Closed won',
            'closed_lost' => 'Closed lost',
            'spam' => 'Spam',
            'triage' => 'Triage (legacy)',
            'proposal' => 'Proposal shaping (legacy)',
            'closed' => 'Closed (legacy)',
        ];
    }

    public function getPriorityOptions(): array
    {
        return [
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'vip' => 'VIP',
            'urgent' => 'Urgent',
        ];
    }


    public function getStatusLabelAttribute(): string
    {
        $options = $this->getStatusOptions();

        return $options[$this->status] ?? $this->humanizeValue($this->status) ?? 'Unknown';
    }

    public function getPriorityLabelAttribute(): string
    {
        $options = $this->getPriorityOptions();

        return $options[$this->priority] ?? $this->humanizeValue($this->priority) ?? 'Normal';
    }

    public function getOwnerDisplayAttribute(): string
    {
        return $this->normalizeDisplayValue($this->owner_name) ?? 'Unassigned';
    }

    public function getSourceDisplayAttribute(): string
    {
        return $this->normalizeDisplayValue($this->source_title)
            ?? $this->humanizeValue($this->source_type)
            ?? 'Direct / unspecified';
    }

    public function getFollowUpQueueSummaryAttribute(): string
    {
        $state = $this->follow_up_queue_state;
        $date = $this->formatDateValue($this->follow_up_date, 'Y-m-d');

        if ($date) {
            return sprintf('%s · %s', $state, $date);
        }

        return $state;
    }

    public function getContinuityToneAttribute(): string
    {
        if ($this->isClosedStatus($this->status)) {
            return 'positive';
        }

        if (!$this->normalizeDisplayValue($this->owner_name)) {
            return 'critical';
        }

        if ($this->follow_up_date instanceof \DateTimeInterface) {
            $today = Carbon::today();

            if ($this->follow_up_date->lt($today)) {
                return 'critical';
            }

            if ($this->follow_up_date->equalTo($today)) {
                return 'warning';
            }

            return 'positive';
        }

        if (in_array((string) $this->status, ['awaiting_guest', 'proposal_sent', 'contacted'], true)) {
            return 'warning';
        }

        return 'neutral';
    }

    public function getQueuePostureAttribute(): string
    {
        if ($this->isClosedStatus($this->status)) {
            return $this->normalizeDisplayValue($this->closed_reason)
                ? 'Closed outcome is recorded and ready for reference.'
                : 'Closed outcome is recorded, but a short closure reason would improve continuity.';
        }

        if (!$this->normalizeDisplayValue($this->owner_name)) {
            return 'This inquiry is unassigned and needs a clear owner.';
        }

        if ($this->follow_up_date instanceof \DateTimeInterface) {
            $today = Carbon::today();

            if ($this->follow_up_date->lt($today)) {
                return 'Follow-up is overdue and needs operator attention.';
            }

            if ($this->follow_up_date->equalTo($today)) {
                return 'Follow-up is due today.';
            }

            return 'A future follow-up checkpoint is already scheduled.';
        }

        if ($this->status === 'awaiting_guest') {
            return 'Waiting on guest response; keep the next review point explicit.';
        }

        if ($this->status === 'proposal_sent') {
            return 'Proposal has been sent; track guest response and the next touchpoint.';
        }

        if ($this->status === 'contacted') {
            return 'Guest has been contacted; add the next checkpoint so the inquiry does not drift.';
        }

        if ($this->status === 'new') {
            return 'Fresh inquiry needs first operator touch.';
        }

        if ($this->status === 'reviewed') {
            return 'Reviewed inquiry should have a named owner and next checkpoint.';
        }

        if ($this->status === 'confirmed') {
            return 'Confirmed inquiry is active; keep owner and guest-facing next action explicit.';
        }

        return 'Workflow is active; keep assignment and next action explicit.';
    }

    public function getContinuityNextActionAttribute(): string
    {
        if ($this->isClosedStatus($this->status)) {
            return 'Leave a concise closure context for future reference, or reopen if active work resumes.';
        }

        if (!$this->normalizeDisplayValue($this->owner_name)) {
            return 'Assign a named owner before the next hand-off.';
        }

        if ($this->follow_up_date instanceof \DateTimeInterface) {
            $today = Carbon::today();

            if ($this->follow_up_date->lt($today)) {
                return 'Update the guest or reschedule the next touchpoint now.';
            }

            if ($this->follow_up_date->equalTo($today)) {
                return 'Handle today\'s checkpoint and keep the working summary current.';
            }

            return 'Keep the working summary current until the next scheduled checkpoint.';
        }

        if ($this->status === 'new') {
            return 'Assign the inquiry and perform the first review or outreach.';
        }

        if ($this->status === 'reviewed') {
            return 'Set the next follow-up date or move the inquiry to the next live status.';
        }

        if ($this->status === 'contacted') {
            return 'Set the next follow-up date so the inquiry stays owned.';
        }

        if ($this->status === 'proposal_sent') {
            return 'Track the guest response window and set the next review checkpoint.';
        }

        if ($this->status === 'awaiting_guest') {
            return 'Keep the waiting status accurate and schedule the next review date.';
        }

        if ($this->status === 'confirmed') {
            return 'Keep owner responsibility and guest-facing next action explicit.';
        }

        return 'Keep the internal summary current for the next operator.';
    }

    public function getLoyaltyRecordLinkStateLabelAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Workspace staged';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            return sprintf('Linked · %s / %s', $record->continuity_status_label, $record->loyalty_stage_label);
        }

        if ($this->loyaltyTransferReady()) {
            return 'Ready to transfer';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Prefill draft ready';
        }

        return 'Live queue only';
    }

    public function getLoyaltyTransferCueLabelAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Schema not active';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            return 'Open linked loyalty record';
        }

        if ($this->loyaltyTransferReady()) {
            return 'Create + open loyalty';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Open prefilled loyalty draft';
        }

        return 'Keep in inquiry queue';
    }


    public function getLoyaltyQueueBacklinkReferenceLabelAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Workspace staged';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            $reference = trim((string) $record->request_reference);

            return $reference !== '' ? $reference : ('Loyalty #' . $record->id);
        }

        if ($this->loyaltyTransferReady()) {
            return 'No linked loyalty record yet';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Draft can be opened from queue';
        }

        return 'Queue-only inquiry';
    }

    public function getLoyaltyQueueBacklinkPostureLabelAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Activate loyalty storage first';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            $parts = [
                $record->continuity_status_label,
                $record->loyalty_stage_label,
            ];

            if ($record->referral_ready) {
                $parts[] = 'Referral ready';
            }

            if ($record->next_review_at instanceof \DateTimeInterface) {
                $parts[] = 'Review ' . $record->next_review_at->format('Y-m-d');
            } else {
                $parts[] = $record->return_value_tier_label;
            }

            return implode(' · ', array_filter($parts));
        }

        if ($this->loyaltyTransferReady()) {
            return 'Transfer-ready but not linked yet';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Draft-ready continuity posture';
        }

        return 'No loyalty backlink yet';
    }

    public function getLoyaltyQueueHistoryCueLabelAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'History staged';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            $outcome = trim((string) $record->latest_touchpoint_outcome_label);

            if ($outcome !== '' && $outcome !== 'No outcome recorded yet.') {
                return $outcome;
            }

            $packet = trim((string) $record->latest_prepared_packet_label);

            if ($packet !== '' && $packet !== 'No packet prepared yet.') {
                return $packet;
            }

            return 'Continuity history started';
        }

        if ($this->loyaltyTransferReady()) {
            return 'No loyalty history yet';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Draft can start history';
        }

        return 'Queue-only history';
    }

    public function getLoyaltyQueueHistoryCueHintAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Activate the loyalty workspace before continuity history can be read from the queue.';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            $parts = [];

            $touch = trim((string) $record->latest_touchpoint_summary);
            if ($touch !== '' && $touch !== 'No touchpoint logged yet.') {
                $parts[] = $touch;
            }

            $packet = trim((string) $record->latest_prepared_packet_label);
            if ($packet !== '' && $packet !== 'No packet prepared yet.') {
                $parts[] = $packet;
            }

            if ($record->next_review_at instanceof \DateTimeInterface) {
                $parts[] = 'Review ' . $record->next_review_at->format('Y-m-d H:i') . ' (' . $record->next_review_window_label . ')';
            } elseif (trim((string) $record->next_review_window_label) !== '') {
                $parts[] = 'Review window ' . $record->next_review_window_label;
            }

            if (!empty($parts)) {
                return implode(' · ', $parts);
            }

            return 'Open the linked loyalty record when deeper continuity history review is needed.';
        }

        if ($this->loyaltyTransferReady()) {
            return 'Create + open loyalty to start a real continuity history directly from the queue.';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Open a seeded draft if continuity history needs to start before final transfer posture is confirmed.';
        }

        return 'This inquiry is still staying in live queue handling, so no loyalty history is visible yet.';
    }

    public function getLoyaltyQueueBacklinkHintAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'The loyalty workspace is not active yet on this install.';
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            $summary = trim((string) $record->continuity_summary);

            if ($summary !== '') {
                return $summary;
            }

            return 'Linked loyalty continuity record is already carrying this inquiry.';
        }

        if ($this->loyaltyTransferReady()) {
            return 'This inquiry can be moved into a live loyalty record directly from the queue.';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'This inquiry can open a seeded loyalty draft, but the live transfer posture is not final yet.';
        }

        return 'No linked loyalty continuity record yet.';
    }

    protected function getLinkedLoyaltyRecord(): ?LoyaltyRecord
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady() || !$this->id) {
            return null;
        }

        if ($this->relationLoaded('loyalty_record')) {
            return $this->getRelation('loyalty_record');
        }

        return $this->loyalty_record;
    }

    protected function loyaltyTransferReady(): bool
    {
        return $this->isClosedStatus($this->status) || !empty($this->closed_at);
    }

    protected function getLoyaltyTransferReadinessScore(): int
    {
        $score = 0;

        if ($this->loyaltyTransferReady()) {
            $score += 2;
        }

        if ($this->normalizeDisplayValue($this->owner_name)) {
            $score += 1;
        }

        if (!in_array((string) $this->priority, ['urgent', 'high'], true)) {
            $score += 1;
        }

        if (empty($this->follow_up_date)) {
            $score += 1;
        }

        return $score;
    }


    public function getLoyaltyQueuePrimaryActionLabelAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Workspace staged';
        }

        if ($this->getLinkedLoyaltyRecord()) {
            return 'Open loyalty';
        }

        if ($this->loyaltyTransferReady()) {
            return 'Create + open loyalty';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Open draft';
        }

        return 'Keep in queue';
    }

    public function getLoyaltyQueuePrimaryActionUrlAttribute(): ?string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady() || !$this->id) {
            return null;
        }

        $record = $this->getLinkedLoyaltyRecord();

        if ($record) {
            return \Backend::url('cabnet/mykonosinquiry/loyaltyrecords/update/' . $record->id) . '?' . http_build_query([
                'bridge_source' => 'inquiry_queue',
                'bridge_state' => 'linked',
                'source_inquiry_id' => $this->id,
            ]);
        }

        if ($this->loyaltyTransferReady()) {
            return \Backend::url('cabnet/mykonosinquiry/inquiries/openloyaltytransfer/' . $this->id);
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return \Backend::url('cabnet/mykonosinquiry/loyaltyrecords/create') . '?source_inquiry_id=' . $this->id;
        }

        return null;
    }

    public function getLoyaltyQueueHistoryActionLabelAttribute(): ?string
    {
        if ($this->getLinkedLoyaltyRecord()) {
            return 'Open loyalty history';
        }

        return null;
    }

    public function getLoyaltyQueueHistoryActionUrlAttribute(): ?string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady() || !$this->id) {
            return null;
        }

        $record = $this->getLinkedLoyaltyRecord();

        if (!$record) {
            return null;
        }

        return \Backend::url('cabnet/mykonosinquiry/loyaltyrecords/update/' . $record->id) . '?' . http_build_query([
            'bridge_source' => 'inquiry_queue',
            'bridge_state' => 'linked',
            'source_inquiry_id' => $this->id,
        ]) . '#primarytab-history';
    }

    public function getLoyaltyQueueSecondaryActionLabelAttribute(): string
    {
        if ($this->getLinkedLoyaltyRecord()) {
            return 'Open inquiry';
        }

        if ($this->loyaltyTransferReady()) {
            return 'Open draft';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'Open inquiry';
        }

        return 'Review inquiry';
    }

    public function getLoyaltyQueueSecondaryActionUrlAttribute(): ?string
    {
        if (!$this->id) {
            return null;
        }

        if (class_exists(LoyaltyRecord::class) && LoyaltyRecord::workspaceStorageReady()) {
            if ($this->getLinkedLoyaltyRecord()) {
                return \Backend::url('cabnet/mykonosinquiry/inquiries/update/' . $this->id);
            }

            if ($this->loyaltyTransferReady()) {
                return \Backend::url('cabnet/mykonosinquiry/loyaltyrecords/create') . '?source_inquiry_id=' . $this->id;
            }
        }

        return \Backend::url('cabnet/mykonosinquiry/inquiries/update/' . $this->id);
    }


    public function getLoyaltyQueuePostureBucketAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'workspace_staged';
        }

        if ($this->getLinkedLoyaltyRecord()) {
            return 'linked';
        }

        if ($this->loyaltyTransferReady()) {
            return 'transfer_ready';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'draft_ready';
        }

        return 'queue_only';
    }

    public function getLoyaltyQueuePostureFilterOptions($scope = null): array
    {
        return static::getLoyaltyQueuePostureOptionMap();
    }

    public static function getLoyaltyQueuePostureOptionMap(): array
    {
        return [
            'linked' => 'Linked to loyalty',
            'transfer_ready' => 'Transfer-ready',
            'draft_ready' => 'Draft-ready',
            'queue_only' => 'Queue-only',
            'workspace_staged' => 'Workspace staged',
        ];
    }

    public static function getLoyaltyQueuePostureCounts(): array
    {
        $options = static::getLoyaltyQueuePostureOptionMap();
        $counts = [];

        foreach ($options as $key => $label) {
            $query = static::query();
            $scope = (object) ['value' => [$key]];
            (new static())->scopeApplyLoyaltyQueuePosture($query, $scope);
            $counts[$key] = [
                'label' => $label,
                'value' => $query->count(),
            ];
        }

        return $counts;
    }

    public static function getLoyaltyQueuePostureBadgeStrip(): array
    {
        $counts = static::getLoyaltyQueuePostureCounts();
        $workspaceReady = class_exists(LoyaltyRecord::class) && LoyaltyRecord::workspaceStorageReady();
        $badges = [];

        foreach ($counts as $key => $bucket) {
            $tone = 'neutral';
            $hint = 'This continuity posture is available in the live queue filter.';

            switch ($key) {
                case 'linked':
                    $tone = 'positive';
                    $hint = 'Continuity already owns these inquiries through a linked loyalty record.';
                    break;

                case 'transfer_ready':
                    $tone = 'warning';
                    $hint = 'Closed inquiries still waiting for a continuity record.';
                    break;

                case 'draft_ready':
                    $tone = 'primary';
                    $hint = 'Operators can open a seeded loyalty draft straight from the queue.';
                    break;

                case 'queue_only':
                    $tone = 'neutral';
                    $hint = 'These inquiries should stay in the live queue until continuity is explicitly needed.';
                    break;

                case 'workspace_staged':
                    $tone = $workspaceReady ? 'neutral' : 'critical';
                    $hint = $workspaceReady
                        ? 'Continuity storage is active, but this bucket should stay quiet in normal operation.'
                        : 'Continuity storage is not active yet, so the filter stays conservative.';
                    break;
            }

            $badges[] = [
                'key' => $key,
                'label' => $bucket['label'],
                'value' => $bucket['value'],
                'tone' => $tone,
                'hint' => $hint,
            ];
        }

        return $badges;
    }

    public static function getLoyaltyQueueTransferSummary(): array
    {
        $counts = static::getLoyaltyQueuePostureCounts();
        $workspaceReady = class_exists(LoyaltyRecord::class) && LoyaltyRecord::workspaceStorageReady();
        $largestBucketKey = 'queue_only';
        $largestBucketValue = $counts[$largestBucketKey]['value'] ?? 0;

        foreach ($counts as $key => $data) {
            if (($data['value'] ?? 0) > $largestBucketValue) {
                $largestBucketKey = $key;
                $largestBucketValue = $data['value'];
            }
        }

        $summary = [
            'headline' => 'Queue posture counts are ready for loyalty routing.',
            'body' => 'Use the compact continuity counts below as a quick scan anchor, then apply the Loyalty Posture filter to isolate the same bucket in the live queue list.',
            'tone' => 'primary',
            'largest_bucket_key' => $largestBucketKey,
            'largest_bucket_label' => $counts[$largestBucketKey]['label'] ?? 'Queue-only',
        ];

        if (!$workspaceReady) {
            $summary['headline'] = 'Loyalty routing is still staged.';
            $summary['body'] = 'The continuity workspace is not fully active yet, so queue-side transfer counts stay conservative until the loyalty storage layer is ready.';
            $summary['tone'] = 'neutral';
            return $summary;
        }

        $transferReady = $counts['transfer_ready']['value'] ?? 0;
        $draftReady = $counts['draft_ready']['value'] ?? 0;
        $linked = $counts['linked']['value'] ?? 0;

        if ($transferReady > 0) {
            $summary['headline'] = 'Closed inquiries are waiting for continuity transfer.';
            $summary['body'] = 'There are ' . $transferReady . ' transfer-ready inquiries without a linked loyalty record. Use the Loyalty Posture filter to isolate them, then create or open continuity directly from the queue row.';
            $summary['tone'] = 'warning';
            return $summary;
        }

        if ($draftReady > 0) {
            $summary['headline'] = 'Seeded continuity drafts are available from the queue.';
            $summary['body'] = 'No closed transfer backlog is visible, but ' . $draftReady . ' inquiries are draft-ready. Use the filter to isolate them and open seeded continuity drafts without leaving the queue.';
            $summary['tone'] = 'primary';
            return $summary;
        }

        if ($linked > 0) {
            $summary['headline'] = 'Continuity ownership is already visible from the queue.';
            $summary['body'] = 'Linked loyalty records are carrying the continuity side of the workflow. Use the filter when you want to review only already-linked inquiries and jump straight into the loyalty workspace.';
            $summary['tone'] = 'positive';
            return $summary;
        }

        return $summary;
    }

    public function scopeApplyLoyaltyQueuePosture($query, $scope): void
    {
        $activeValues = array_values(array_filter((array) ($scope->value ?? []), static function ($value) {
            return $value !== null && $value !== '';
        }));

        if (!count($activeValues)) {
            return;
        }

        $workspaceReady = class_exists(LoyaltyRecord::class) && LoyaltyRecord::workspaceStorageReady();

        if (!$workspaceReady) {
            if (in_array('workspace_staged', $activeValues, true)) {
                return;
            }

            $query->whereRaw('1 = 0');
            return;
        }

        $query->where(function ($outerQuery) use ($activeValues) {
            foreach ($activeValues as $value) {
                $outerQuery->orWhere(function ($branchQuery) use ($value) {
                    switch ($value) {
                        case 'linked':
                            $branchQuery->whereHas('loyalty_record');
                            break;

                        case 'transfer_ready':
                            $branchQuery->whereDoesntHave('loyalty_record')
                                ->where(function ($statusQuery) {
                                    $statusQuery->whereIn('status', ['closed_won', 'closed_lost', 'spam', 'closed'])
                                        ->orWhereNotNull('closed_at');
                                });
                            break;

                        case 'draft_ready':
                            $branchQuery->whereDoesntHave('loyalty_record')
                                ->where(function ($statusQuery) {
                                    $statusQuery->whereNotIn('status', ['closed_won', 'closed_lost', 'spam', 'closed'])
                                        ->orWhereNull('status');
                                })
                                ->whereNull('closed_at')
                                ->whereNotNull('owner_name')
                                ->whereRaw("TRIM(owner_name) <> ''")
                                ->where(function ($priorityQuery) {
                                    $priorityQuery->whereNotIn('priority', ['urgent', 'high'])
                                        ->orWhereNull('priority');
                                })
                                ->whereNull('follow_up_date');
                            break;

                        case 'queue_only':
                            $branchQuery->whereDoesntHave('loyalty_record')
                                ->where(function ($queueOnlyQuery) {
                                    $queueOnlyQuery->whereIn('status', ['closed_won', 'closed_lost', 'spam', 'closed'])
                                        ->orWhereNotNull('closed_at')
                                        ->orWhereNull('owner_name')
                                        ->orWhereRaw("TRIM(owner_name) = ''")
                                        ->orWhereIn('priority', ['urgent', 'high'])
                                        ->orWhereNotNull('follow_up_date');
                                });
                            break;

                        case 'workspace_staged':
                            $branchQuery->whereRaw('1 = 0');
                            break;
                    }
                });
            }
        });
    }

    public function getLoyaltyQueueActionHintAttribute(): string
    {
        if (!class_exists(LoyaltyRecord::class) || !LoyaltyRecord::workspaceStorageReady()) {
            return 'Activate the loyalty workspace before using queue transfer actions.';
        }

        if ($this->getLinkedLoyaltyRecord()) {
            return 'This inquiry already has continuity ownership; jump straight to the linked loyalty record or reopen the inquiry context.';
        }

        if ($this->loyaltyTransferReady()) {
            return 'This inquiry is transfer-ready and can open a live loyalty record directly from the queue.';
        }

        if ($this->getLoyaltyTransferReadinessScore() >= 3) {
            return 'This inquiry is not fully transfer-ready, but a seeded loyalty draft can be opened without leaving the queue.';
        }

        return 'Keep this record in the inquiry queue until ownership and next-step posture are clearer.';
    }


    public function getFollowUpQueueStateAttribute(): string
    {
        if ($this->isClosedStatus($this->status)) {
            return 'Closed';
        }

        if (!$this->normalizeDisplayValue($this->owner_name)) {
            return 'Unassigned';
        }

        if ($this->follow_up_date instanceof \DateTimeInterface) {
            $today = Carbon::today();

            if ($this->follow_up_date->lt($today)) {
                return 'Overdue';
            }

            if ($this->follow_up_date->equalTo($today)) {
                return 'Due today';
            }

            return 'Scheduled';
        }

        if ($this->status === 'new') {
            return 'Needs first touch';
        }

        return 'Unscheduled';
    }

    public function getFollowUpQueueToneAttribute(): string
    {
        $state = $this->follow_up_queue_state;

        if (in_array($state, ['Closed', 'Scheduled'], true)) {
            return 'positive';
        }

        if (in_array($state, ['Unassigned', 'Overdue'], true)) {
            return 'critical';
        }

        if (in_array($state, ['Due today', 'Unscheduled'], true)) {
            return 'warning';
        }

        return 'neutral';
    }

    public function getFollowUpQueueNoteAttribute(): string
    {
        $state = $this->follow_up_queue_state;

        if ($state === 'Closed') {
            return 'This inquiry is closed. Keep closure context readable in case it needs to be reopened.';
        }

        if ($state === 'Unassigned') {
            return 'No named owner is visible yet, so the next follow-up could drift between operators.';
        }

        if ($state === 'Overdue') {
            return 'The follow-up date has already passed and this inquiry should be brought back into an active checkpoint now.';
        }

        if ($state === 'Due today') {
            return 'This inquiry needs attention today. Handle the checkpoint and leave clear context for the next operator.';
        }

        if ($state === 'Scheduled') {
            return 'A future checkpoint is already on the calendar. Keep the working summary aligned until then.';
        }

        if ($state === 'Needs first touch') {
            return 'This is still a fresh inquiry. The first owner and first outreach checkpoint should be made explicit.';
        }

        return 'The inquiry is active but no next checkpoint is currently set.';
    }

    public function getFollowUpQueueActionAttribute(): string
    {
        $state = $this->follow_up_queue_state;

        if ($state === 'Closed') {
            return 'Leave a concise closure reason, or reopen the inquiry if active work resumes.';
        }

        if ($state === 'Unassigned') {
            return 'Assign a named owner before the next hand-off.';
        }

        if ($state === 'Overdue') {
            return 'Contact the guest or reschedule the next checkpoint now.';
        }

        if ($state === 'Due today') {
            return "Complete today's checkpoint and update the operator summary.";
        }

        if ($state === 'Scheduled') {
            return 'Keep the brief and internal notes current until the scheduled date.';
        }

        if ($state === 'Needs first touch') {
            return 'Perform first review or outreach and add the first follow-up date.';
        }

        return 'Set the next follow-up date so queue ownership remains explicit.';
    }

    public function getServicesListAttribute(): string
    {
        $services = (array) ($this->services_json ?: []);
        $services = array_values(array_filter(array_map('trim', $services)));

        if (empty($services)) {
            return 'No service selections were captured.';
        }

        return implode(PHP_EOL, array_map(function ($service) {
            return '- ' . $this->humanizeValue($service);
        }, $services));
    }

    public function getServicesInlineAttribute(): string
    {
        $services = (array) ($this->services_json ?: []);
        $services = array_values(array_filter(array_map('trim', $services)));

        if (empty($services)) {
            return 'General planning';
        }

        return implode(', ', array_map(function ($service) {
            return $this->humanizeValue($service);
        }, $services));
    }

    public function getGuestSnapshotAttribute(): string
    {
        return $this->formatSummary([
            'Name' => $this->full_name,
            'Email' => $this->email,
            'Phone' => $this->phone,
            'Country' => $this->country,
            'Contact preference' => $this->contact_preference,
        ], 'Guest identity and contact details are still sparse.');
    }

    public function getStaySnapshotAttribute(): string
    {
        return $this->formatSummary([
            'Arrival date' => $this->formatDateValue($this->arrival_date, 'Y-m-d'),
            'Departure date' => $this->formatDateValue($this->departure_date, 'Y-m-d'),
            'Arrival window' => $this->arrival_window,
            'Guests' => $this->guests,
            'Group composition' => $this->group_composition,
            'Children travelling' => $this->children_travelling,
            'Travel style' => $this->travel_style,
            'Stay mood' => $this->stay_mood,
            'Budget' => $this->budget,
        ], 'Trip timing and stay profile have not been filled in yet.');
    }

    public function getSourceSnapshotAttribute(): string
    {
        return $this->formatSummary([
            'Source type' => $this->humanizeValue($this->source_type),
            'Source title' => $this->source_title,
            'Source slug' => $this->source_slug,
            'Source URL' => $this->source_url,
            'Requested mode' => $this->humanizeValue($this->requested_mode),
        ], 'No explicit source context was captured for this inquiry.');
    }

    public function getConciergeBriefAttribute(): string
    {
        return $this->formatSummary([
            'Focus / services' => $this->services_inline,
            'Arrival mode' => $this->arrival_mode,
            'Privacy level' => $this->privacy_level,
            'Villa area' => $this->villa_area,
            'Occasion' => $this->occasion_type,
            'Special moments' => $this->special_moments,
            'Accommodation status' => $this->accommodation_status,
            'Dining style' => $this->dining_style,
            'Nightlife interest' => $this->nightlife_interest,
            'Dietary needs' => $this->dietary_needs,
            'Operator intent' => $this->operator_intent,
            'Urgency hint' => $this->humanizeValue($this->urgency_hint),
            'Guest brief' => $this->details,
        ], 'The concierge brief is still minimal.');
    }

    public function getPayloadPrettyJsonAttribute(): string
    {
        $payload = $this->payload_json;

        if (empty($payload)) {
            return '{}';
        }

        if (is_string($payload)) {
            return $payload;
        }

        $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $json !== false ? $json : '{}';
    }

    public function getHistoryPreviewAttribute(): string
    {
        $lines = [];

        foreach ($this->notes as $note) {
            $stamp = optional($note->created_at)->format('Y-m-d H:i');
            $type = ucfirst(trim((string) ($note->note_type ?: 'internal')));
            $author = trim((string) ($note->author_name ?: 'System'));
            $body = trim((string) $note->body);
            $lines[] = sprintf('[%s] %s / %s', $stamp, $type, $author);
            $lines[] = $body;
            $lines[] = '';
        }

        if (empty($lines)) {
            return 'No history entries yet.';
        }

        return trim(implode(PHP_EOL, $lines));
    }

    public function beforeSave(): void
    {
        $this->applyWorkflowDefaults();
        $this->captureWorkflowChanges();
    }

    public function afterSave(): void
    {
        $this->appendWorkflowChangeNotes();
    }

    public function afterCreate(): void
    {
        if (!$this->request_reference) {
            $prefix = strtoupper((string) config('cabnet.mykonosinquiry::reference_prefix', 'MYK'));
            $reference = sprintf('%s-%s-%06d', $prefix, date('ymd'), $this->id);
            $this->newQuery()->whereKey($this->id)->update(['request_reference' => $reference]);
            $this->request_reference = $reference;
        }
    }

    protected function applyWorkflowDefaults(): void
    {
        if (!$this->priority) {
            $this->priority = 'normal';
        }

        if ($this->status === 'contacted' && !$this->last_contacted_at) {
            $this->last_contacted_at = Carbon::now();
        }

        if ($this->isClosedStatus($this->status)) {
            if (!$this->closed_at) {
                $this->closed_at = Carbon::now();
            }
        } elseif ($this->closed_at) {
            $this->closed_at = null;
        }
    }

    protected function captureWorkflowChanges(): void
    {
        $this->workflowChanges = [];

        if (!$this->exists) {
            return;
        }

        $trackedFields = [
            'status' => 'Status',
            'priority' => 'Priority',
            'owner_name' => 'Owner',
            'follow_up_date' => 'Follow up date',
            'last_contacted_at' => 'Last contacted',
            'closed_at' => 'Closed at',
            'closed_reason' => 'Closed reason',
        ];

        foreach ($trackedFields as $field => $label) {
            $old = $this->normalizeWorkflowValue($this->getOriginal($field));
            $new = $this->normalizeWorkflowValue($this->{$field} ?? null);

            if ($old !== $new) {
                $this->workflowChanges[$field] = [
                    'label' => $label,
                    'old' => $old,
                    'new' => $new,
                ];
            }
        }
    }

    protected function appendWorkflowChangeNotes(): void
    {
        if (empty($this->workflowChanges) || !Schema::hasTable('cabnet_mykonos_inquiry_notes')) {
            return;
        }

        foreach ($this->workflowChanges as $change) {
            $old = $change['old'] !== null && $change['old'] !== '' ? $change['old'] : '—';
            $new = $change['new'] !== null && $change['new'] !== '' ? $change['new'] : '—';

            $note = new InquiryNote();
            $note->inquiry_id = $this->id;
            $note->note_type = 'system';
            $note->author_name = 'System';
            $note->body = sprintf('%s changed from "%s" to "%s".', $change['label'], $old, $new);
            $note->is_internal = true;
            $note->save();
        }

        $this->workflowChanges = [];
    }

    protected function normalizeWorkflowValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            return $trimmed === '' ? null : $trimmed;
        }

        return trim((string) $value);
    }

    protected function formatSummary(array $items, string $fallback): string
    {
        $lines = [];

        foreach ($items as $label => $value) {
            $value = $this->normalizeDisplayValue($value);
            if ($value === null) {
                continue;
            }

            $lines[] = sprintf('%s: %s', $label, $value);
        }

        return !empty($lines) ? implode(PHP_EOL, $lines) : $fallback;
    }

    protected function normalizeDisplayValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i');
        }

        if (is_array($value)) {
            $value = implode(', ', array_filter(array_map('trim', $value)));
        }

        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }

    protected function formatDateValue($value, string $format = 'Y-m-d H:i'): ?string
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

    protected function humanizeValue($value): ?string
    {
        $value = $this->normalizeDisplayValue($value);
        if ($value === null) {
            return null;
        }

        return ucwords(str_replace(['_', '-'], ' ', $value));
    }

    protected function isClosedStatus(?string $status): bool
    {
        return in_array((string) $status, ['closed_won', 'closed_lost', 'spam', 'closed'], true);
    }
}
