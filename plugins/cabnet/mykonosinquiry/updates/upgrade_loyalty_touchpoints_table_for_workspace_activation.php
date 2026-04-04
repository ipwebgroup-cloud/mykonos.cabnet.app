<?php namespace Cabnet\MykonosInquiry\Updates;

use October\Rain\Database\Updates\Migration;

require_once __DIR__ . '/LoyaltyWorkspaceSchema.php';

class UpgradeLoyaltyTouchpointsTableForWorkspaceActivation extends Migration
{
    public function up()
    {
        LoyaltyWorkspaceSchema::ensureTouchpointColumns();
    }

    public function down()
    {
        // Intentionally no-op to avoid destructive rollback on the live inquiry plugin line.
    }
}
