<?php namespace Cabnet\MykonosInquiry\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateInquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('cabnet_mykonos_inquiries', function ($table) {
            $table->increments('id');
            $table->string('request_reference')->nullable()->index();
            $table->string('source_type')->nullable()->index();
            $table->string('source_slug')->nullable()->index();
            $table->string('source_title')->nullable();
            $table->string('source_url', 500)->nullable();
            $table->string('requested_mode')->nullable()->index();
            $table->string('full_name')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->integer('guests')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('arrival_window')->nullable();
            $table->string('group_composition')->nullable();
            $table->string('children_travelling')->nullable();
            $table->string('budget')->nullable();
            $table->string('travel_style')->nullable();
            $table->string('stay_mood')->nullable();
            $table->string('arrival_mode')->nullable();
            $table->string('privacy_level')->nullable();
            $table->string('villa_area')->nullable();
            $table->string('occasion_type')->nullable();
            $table->text('special_moments')->nullable();
            $table->string('accommodation_status')->nullable();
            $table->string('dining_style')->nullable();
            $table->string('nightlife_interest')->nullable();
            $table->text('dietary_needs')->nullable();
            $table->string('contact_preference')->nullable();
            $table->longText('details')->nullable();
            $table->longText('services_json')->nullable();
            $table->string('status')->default('new')->index();
            $table->string('owner_name')->nullable()->index();
            $table->date('follow_up_date')->nullable();
            $table->string('urgency_hint')->nullable()->index();
            $table->string('operator_intent')->nullable();
            $table->longText('guest_summary')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->longText('payload_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cabnet_mykonos_inquiries');
    }
}
