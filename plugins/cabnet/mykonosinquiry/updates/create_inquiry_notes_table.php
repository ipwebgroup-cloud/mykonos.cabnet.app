<?php namespace Cabnet\MykonosInquiry\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateInquiryNotesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('cabnet_mykonos_inquiry_notes')) {
            return;
        }

        Schema::create('cabnet_mykonos_inquiry_notes', function ($table) {
            $table->increments('id');
            $table->integer('inquiry_id')->unsigned()->index();
            $table->string('note_type')->default('internal')->index();
            $table->string('author_name')->nullable();
            $table->text('body');
            $table->boolean('is_internal')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cabnet_mykonos_inquiry_notes');
    }
}
