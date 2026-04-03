<?php namespace Cabnet\MykonosInquiry\Models;

use Model;

class LoyaltyTouchpoint extends Model
{
    public $table = 'cabnet_mykonos_loyalty_touchpoints';

    protected $guarded = ['id'];

    protected $dates = [
        'touchpoint_at',
        'next_step_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public $jsonable = ['payload_json'];

    public $belongsTo = [
        'loyalty_record' => [LoyaltyRecord::class, 'key' => 'loyalty_record_id'],
    ];
}
