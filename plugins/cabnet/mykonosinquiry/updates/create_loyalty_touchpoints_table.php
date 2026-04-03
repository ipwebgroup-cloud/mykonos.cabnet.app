<?php namespace Cabnet\MykonosInquiry\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;
use October\Rain\Database\Schema\Blueprint;

class CreateLoyaltyTouchpointsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cabnet_mykonos_loyalty_touchpoints')) {
            return;
        }

        Schema::create('cabnet_mykonos_loyalty_touchpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('loyalty_record_id')->index();
            $table->string('touchpoint_type', 60)->default('internal');
            $table->string('author_name', 120)->nullable();
            $table->mediumText('body')->nullable();
            $table->boolean('is_internal')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cabnet_mykonos_loyalty_touchpoints');
    }
}
