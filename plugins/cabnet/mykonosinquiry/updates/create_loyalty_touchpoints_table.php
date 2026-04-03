<?php namespace Cabnet\MykonosInquiry\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLoyaltyTouchpointsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cabnet_mykonos_loyalty_touchpoints')) {
            return;
        }

        Schema::create('cabnet_mykonos_loyalty_touchpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('loyalty_record_id')->nullable()->index();
            $table->unsignedInteger('source_inquiry_id')->nullable()->index();
            $table->string('touchpoint_type', 80)->default('review')->index();
            $table->string('touchpoint_channel', 80)->nullable()->index();
            $table->string('touchpoint_outcome', 80)->nullable()->index();
            $table->timestamp('touchpoint_at')->nullable()->index();
            $table->timestamp('next_step_at')->nullable()->index();
            $table->string('operator_name', 120)->nullable();
            $table->string('reference_code', 120)->nullable()->index();
            $table->text('touchpoint_summary')->nullable();
            $table->mediumText('payload_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        if (Schema::hasTable('cabnet_mykonos_loyalty_touchpoints')) {
            Schema::dropIfExists('cabnet_mykonos_loyalty_touchpoints');
        }
    }
}
