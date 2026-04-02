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
