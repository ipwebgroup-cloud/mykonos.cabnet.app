<?php namespace Cabnet\MykonosInquiry\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AddWorkflowFieldsToInquiriesTable extends Migration
{
    public function up()
    {
        Schema::table('cabnet_mykonos_inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('cabnet_mykonos_inquiries', 'last_contacted_at')) {
                $table->dateTime('last_contacted_at')->nullable()->after('follow_up_date');
            }

            if (!Schema::hasColumn('cabnet_mykonos_inquiries', 'closed_at')) {
                $table->dateTime('closed_at')->nullable()->after('last_contacted_at');
            }

            if (!Schema::hasColumn('cabnet_mykonos_inquiries', 'closed_reason')) {
                $table->text('closed_reason')->nullable()->after('closed_at');
            }
        });
    }

    public function down()
    {
        Schema::table('cabnet_mykonos_inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('cabnet_mykonos_inquiries', 'closed_reason')) {
                $table->dropColumn('closed_reason');
            }

            if (Schema::hasColumn('cabnet_mykonos_inquiries', 'closed_at')) {
                $table->dropColumn('closed_at');
            }

            if (Schema::hasColumn('cabnet_mykonos_inquiries', 'last_contacted_at')) {
                $table->dropColumn('last_contacted_at');
            }
        });
    }
}
