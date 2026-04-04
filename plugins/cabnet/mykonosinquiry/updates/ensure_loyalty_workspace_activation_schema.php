<?php namespace Cabnet\MykonosInquiry\Updates;

use October\Rain\Database\Updates\Migration;

require_once __DIR__ . '/LoyaltyWorkspaceSchema.php';

class EnsureLoyaltyWorkspaceActivationSchema extends Migration
{
    public function up()
    {
        LoyaltyWorkspaceSchema::ensureRecordTable();
LoyaltyWorkspaceSchema::ensureTouchpointTable();
LoyaltyWorkspaceSchema::ensureRecordColumns();
LoyaltyWorkspaceSchema::ensureTouchpointColumns();
    }

    public function down()
    {
        // Intentionally no-op to avoid destructive rollback on the live inquiry plugin line.
    }
}
