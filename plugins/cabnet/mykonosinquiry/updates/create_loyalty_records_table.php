<?php namespace Cabnet\MykonosInquiry\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;
use October\Rain\Database\Schema\Blueprint;

class CreateLoyaltyRecordsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cabnet_mykonos_loyalty_records')) {
            return;
        }

        Schema::create('cabnet_mykonos_loyalty_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_inquiry_id')->nullable()->unique();
            $table->string('request_reference', 40)->nullable()->index();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone', 80)->nullable();
            $table->string('country', 120)->nullable();
            $table->string('continuity_status', 60)->default('active_retention')->index();
            $table->string('loyalty_stage', 60)->default('review')->index();
            $table->boolean('referral_ready')->default(false)->index();
            $table->string('return_value_tier', 60)->default('watch')->index();
            $table->string('preferred_season', 120)->nullable();
            $table->string('revisit_window', 191)->nullable();
            $table->timestamp('next_review_at')->nullable()->index();
            $table->timestamp('last_retention_contact_at')->nullable();
            $table->date('last_visit_at')->nullable();
            $table->text('service_focus_summary')->nullable();
            $table->text('source_summary')->nullable();
            $table->mediumText('continuity_summary')->nullable();
            $table->mediumText('retention_notes')->nullable();
            $table->mediumText('tags_json')->nullable();
            $table->string('created_by', 120)->nullable();
            $table->string('owner_name', 120)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cabnet_mykonos_loyalty_records');
    }
}
