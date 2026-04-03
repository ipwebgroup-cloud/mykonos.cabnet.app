<?php namespace Cabnet\MykonosInquiry\Models;

use Model;

class LoyaltyTouchpoint extends Model
{
    public $table = 'cabnet_mykonos_loyalty_touchpoints';

    protected $guarded = ['id'];

    public $belongsTo = [
        'loyalty_record' => [LoyaltyRecord::class, 'key' => 'loyalty_record_id'],
    ];
}
