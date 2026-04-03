<?php namespace Cabnet\MykonosInquiry\Updates;

use Db;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpgradeLoyaltyTouchpointsTableForWorkspaceActivation extends Migration
{
    protected string $table = 'cabnet_mykonos_loyalty_touchpoints';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            return;
        }

        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'author_name')) {
                $table->string('author_name', 120)->nullable();
            }

            if (!Schema::hasColumn($this->table, 'body')) {
                $table->text('body')->nullable();
            }

            if (!Schema::hasColumn($this->table, 'is_internal')) {
                $table->boolean('is_internal')->default(true)->index();
            }
        });

        if (Schema::hasColumn($this->table, 'operator_name') && Schema::hasColumn($this->table, 'author_name')) {
            foreach (Db::table($this->table)
                ->select('id', 'operator_name', 'author_name')
                ->whereNotNull('operator_name')
                ->get() as $row) {
                $current = trim((string) ($row->author_name ?? ''));
                $legacy = trim((string) ($row->operator_name ?? ''));

                if ($current === '' && $legacy !== '') {
                    Db::table($this->table)
                        ->where('id', $row->id)
                        ->update(['author_name' => $legacy]);
                }
            }
        }

        if (Schema::hasColumn($this->table, 'touchpoint_summary') && Schema::hasColumn($this->table, 'body')) {
            foreach (Db::table($this->table)
                ->select('id', 'touchpoint_summary', 'body')
                ->whereNotNull('touchpoint_summary')
                ->get() as $row) {
                $current = trim((string) ($row->body ?? ''));
                $legacy = trim((string) ($row->touchpoint_summary ?? ''));

                if ($current === '' && $legacy !== '') {
                    Db::table($this->table)
                        ->where('id', $row->id)
                        ->update(['body' => $legacy]);
                }
            }
        }
    }

    public function down()
    {
        // Non-destructive schema alignment patch. Columns are retained on rollback.
    }
}
