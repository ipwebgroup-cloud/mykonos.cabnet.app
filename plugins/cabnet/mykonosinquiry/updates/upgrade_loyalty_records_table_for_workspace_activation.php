<?php namespace Cabnet\MykonosInquiry\Updates;

use Db;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpgradeLoyaltyRecordsTableForWorkspaceActivation extends Migration
{
    protected string $table = 'cabnet_mykonos_loyalty_records';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            return;
        }

        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'request_reference')) {
                $table->string('request_reference', 120)->nullable()->index();
            }

            if (!Schema::hasColumn($this->table, 'guest_name')) {
                $table->string('guest_name', 150)->nullable()->index();
            }

            if (!Schema::hasColumn($this->table, 'guest_email')) {
                $table->string('guest_email', 180)->nullable()->index();
            }

            if (!Schema::hasColumn($this->table, 'guest_phone')) {
                $table->string('guest_phone', 80)->nullable();
            }

            if (!Schema::hasColumn($this->table, 'country')) {
                $table->string('country', 120)->nullable();
            }

            if (!Schema::hasColumn($this->table, 'owner_name')) {
                $table->string('owner_name', 120)->nullable()->index();
            }

            if (!Schema::hasColumn($this->table, 'created_by')) {
                $table->string('created_by', 120)->nullable();
            }

            if (!Schema::hasColumn($this->table, 'service_focus_summary')) {
                $table->text('service_focus_summary')->nullable();
            }

            if (!Schema::hasColumn($this->table, 'source_summary')) {
                $table->text('source_summary')->nullable();
            }

            if (!Schema::hasColumn($this->table, 'continuity_summary')) {
                $table->text('continuity_summary')->nullable();
            }

            if (!Schema::hasColumn($this->table, 'retention_notes')) {
                $table->text('retention_notes')->nullable();
            }

            if (!Schema::hasColumn($this->table, 'revisit_window')) {
                $table->string('revisit_window', 150)->nullable();
            }

            if (!Schema::hasColumn($this->table, 'last_visit_at')) {
                $table->date('last_visit_at')->nullable()->index();
            }

            if (!Schema::hasColumn($this->table, 'tags_json')) {
                $table->mediumText('tags_json')->nullable();
            }
        });

        if (Schema::hasColumn($this->table, 'internal_retention_notes') && Schema::hasColumn($this->table, 'retention_notes')) {
            foreach (Db::table($this->table)
                ->select('id', 'internal_retention_notes', 'retention_notes')
                ->whereNotNull('internal_retention_notes')
                ->get() as $row) {
                $current = trim((string) ($row->retention_notes ?? ''));
                $legacy = trim((string) ($row->internal_retention_notes ?? ''));

                if ($current === '' && $legacy !== '') {
                    Db::table($this->table)
                        ->where('id', $row->id)
                        ->update(['retention_notes' => $legacy]);
                }
            }
        }

        if (Schema::hasColumn($this->table, 'revisit_window_label') && Schema::hasColumn($this->table, 'revisit_window')) {
            foreach (Db::table($this->table)
                ->select('id', 'revisit_window_label', 'revisit_window')
                ->whereNotNull('revisit_window_label')
                ->get() as $row) {
                $current = trim((string) ($row->revisit_window ?? ''));
                $legacy = trim((string) ($row->revisit_window_label ?? ''));

                if ($current === '' && $legacy !== '') {
                    Db::table($this->table)
                        ->where('id', $row->id)
                        ->update(['revisit_window' => $legacy]);
                }
            }
        }
    }

    public function down()
    {
        // Non-destructive schema alignment patch. Columns are retained on rollback.
    }
}
