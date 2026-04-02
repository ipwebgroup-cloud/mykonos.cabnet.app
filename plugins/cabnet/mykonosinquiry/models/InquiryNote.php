<?php namespace Cabnet\MykonosInquiry\Models;

use Model;

class InquiryNote extends Model
{
    public $table = 'cabnet_mykonos_inquiry_notes';

    protected $guarded = ['id'];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public $belongsTo = [
        'inquiry' => [Inquiry::class],
    ];

    public function beforeCreate(): void
    {
        if (!$this->note_type) {
            $this->note_type = 'internal';
        }

        if ($this->is_internal === null) {
            $this->is_internal = true;
        }
    }

    public function getNoteTypeOptions(): array
    {
        return [
            'system' => 'System',
            'internal' => 'Internal',
            'follow_up' => 'Follow Up',
            'guest_update' => 'Guest Update',
        ];
    }

    public function getSummaryAttribute(): string
    {
        $stamp = optional($this->created_at)->format('Y-m-d H:i');
        $author = trim((string) ($this->author_name ?: 'System'));
        $type = trim((string) ($this->note_type ?: 'internal'));

        return sprintf('[%s] %s / %s: %s', $stamp, ucfirst($type), $author, trim((string) $this->body));
    }
}
