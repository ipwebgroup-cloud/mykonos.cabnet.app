<?php namespace Cabnet\MykonosInquiry\Models;

use Carbon\Carbon;
use Model;

class LoyaltyRecord extends Model
{
    public $table = 'cabnet_mykonos_loyalty_records';

    protected $guarded = ['id'];

    protected $dates = [
        'next_review_at',
        'last_retention_contact_at',
        'last_visit_at',
        'created_at',
        'updated_at',
    ];

    public $jsonable = ['tags_json'];

    public $hasMany = [
        'touchpoints' => [LoyaltyTouchpoint::class, 'order' => 'created_at desc'],
    ];

    public $belongsTo = [
        'source_inquiry' => [Inquiry::class, 'key' => 'source_inquiry_id'],
    ];

    public function getContinuityStatusOptions(): array
    {
        return [
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
            'Guest'        => $this->guest_name,
            'Email'        => $this->guest_email,
            'Phone'        => $this->guest_phone,
            'Country'      => $this->country,
            'Owner'        => $this->owner_name,
            'Referral ready' => $this->referral_ready ? 'Yes' : 'No',
        ], 'Guest continuity basics are still sparse.');
    }

    public function getHistoryPreviewAttribute(): string
    {
        $lines = [];

        foreach ($this->touchpoints as $touchpoint) {
            $stamp = optional($touchpoint->created_at)->format('Y-m-d H:i');
            $type = ucfirst(trim((string) ($touchpoint->touchpoint_type ?: 'internal')));
            $author = trim((string) ($touchpoint->author_name ?: 'System'));
            $body = trim((string) $touchpoint->body);

            $lines[] = sprintf('[%s] %s / %s', $stamp, $type, $author);
            $lines[] = $body;
            $lines[] = '';
        }

        if (empty($lines)) {
            return 'No loyalty continuity touchpoints yet.';
        }

        return trim(implode(PHP_EOL, $lines));
    }

    public static function syncFromInquiry(Inquiry $inquiry, array $overrides = [], ?string $operatorName = null): ?self
    {
        if (!$inquiry || !$inquiry->id) {
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
        $record->next_review_at = $record->next_review_at ?: Carbon::now()->addDays(14);

        foreach ($overrides as $field => $value) {
            $record->{$field} = $value;
        }

        $record->save();

        if ($record->wasRecentlyCreated) {
            $record->appendTouchpoint(
                'system',
                'Created from inquiry continuity handoff' . ($inquiry->request_reference ? ' (' . $inquiry->request_reference . ')' : '') . '.',
                $operatorName
            );
        }

        return $record;
    }

    public function appendTouchpoint(string $type, string $body, ?string $authorName = null): LoyaltyTouchpoint
    {
        $touchpoint = new LoyaltyTouchpoint();
        $touchpoint->loyalty_record_id = $this->id;
        $touchpoint->touchpoint_type = $type;
        $touchpoint->author_name = $authorName ?: 'Operator';
        $touchpoint->body = trim($body);
        $touchpoint->is_internal = true;
        $touchpoint->save();

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
