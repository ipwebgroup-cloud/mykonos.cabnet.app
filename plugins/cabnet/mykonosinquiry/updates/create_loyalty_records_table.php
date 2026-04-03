<?php namespace Cabnet\MykonosInquiry\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLoyaltyRecordsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cabnet_mykonos_loyalty_records')) {
            return;
        }

        Schema::create('cabnet_mykonos_loyalty_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_inquiry_id')->nullable()->index();
            $table->string('continuity_status', 50)->default('draft')->index();
            $table->string('loyalty_stage', 50)->nullable()->index();
            $table->boolean('referral_ready')->default(false)->index();
            $table->boolean('return_value_candidate')->default(false)->index();
            $table->string('return_value_tier', 50)->nullable()->index();
            $table->timestamp('next_review_at')->nullable()->index();
            $table->timestamp('last_retention_contact_at')->nullable()->index();
            $table->string('preferred_season', 100)->nullable();
            $table->string('revisit_window_label', 150)->nullable();
            $table->text('internal_retention_notes')->nullable();
            $table->mediumText('payload_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        if (Schema::hasTable('cabnet_mykonos_loyalty_records')) {
            Schema::dropIfExists('cabnet_mykonos_loyalty_records');
        }
    }
}
