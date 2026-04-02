<?php namespace Cabnet\MykonosInquiry\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddPriorityToInquiriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('cabnet_mykonos_inquiries')) {
            return;
        }

        Schema::table('cabnet_mykonos_inquiries', function ($table) {
            if (!Schema::hasColumn('cabnet_mykonos_inquiries', 'priority')) {
                $table->string('priority')->default('normal')->after('status')->index();
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('cabnet_mykonos_inquiries')) {
            return;
        }

        Schema::table('cabnet_mykonos_inquiries', function ($table) {
            if (Schema::hasColumn('cabnet_mykonos_inquiries', 'priority')) {
                $table->dropColumn('priority');
            }
        });
    }
}
