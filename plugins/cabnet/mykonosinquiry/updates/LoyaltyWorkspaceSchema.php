<?php namespace Cabnet\MykonosInquiry\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;

class LoyaltyWorkspaceSchema
{
    public const RECORD_TABLE = 'cabnet_mykonos_loyalty_records';
    public const TOUCHPOINT_TABLE = 'cabnet_mykonos_loyalty_touchpoints';

    public static function ensureRecordTable()
    {
        if (!Schema::hasTable(self::RECORD_TABLE)) {
            Schema::create(self::RECORD_TABLE, function (Blueprint $table) {
                $table->increments('id');
                self::appendRecordColumns($table, array_keys(self::recordColumnMap()));
                $table->timestamps();
            });

            return;
        }

        self::ensureRecordColumns();
    }

    public static function ensureTouchpointTable()
    {
        if (!Schema::hasTable(self::TOUCHPOINT_TABLE)) {
            Schema::create(self::TOUCHPOINT_TABLE, function (Blueprint $table) {
                $table->increments('id');
                self::appendTouchpointColumns($table, array_keys(self::touchpointColumnMap()));
                $table->timestamps();
            });

            return;
        }

        self::ensureTouchpointColumns();
    }

    public static function ensureRecordColumns()
    {
        if (!Schema::hasTable(self::RECORD_TABLE)) {
            self::ensureRecordTable();
            return;
        }

        $missing = [];
        foreach (array_keys(self::recordColumnMap()) as $column) {
            if (!Schema::hasColumn(self::RECORD_TABLE, $column)) {
                $missing[] = $column;
            }
        }

        if (!$missing) {
            return;
        }

        Schema::table(self::RECORD_TABLE, function (Blueprint $table) use ($missing) {
            self::appendRecordColumns($table, $missing);
        });
    }

    public static function ensureTouchpointColumns()
    {
        if (!Schema::hasTable(self::TOUCHPOINT_TABLE)) {
            self::ensureTouchpointTable();
            return;
        }

        $missing = [];
        foreach (array_keys(self::touchpointColumnMap()) as $column) {
            if (!Schema::hasColumn(self::TOUCHPOINT_TABLE, $column)) {
                $missing[] = $column;
            }
        }

        if (!$missing) {
            return;
        }

        Schema::table(self::TOUCHPOINT_TABLE, function (Blueprint $table) use ($missing) {
            self::appendTouchpointColumns($table, $missing);
        });
    }

    protected static function appendRecordColumns(Blueprint $table, array $columns)
    {
        $map = self::recordColumnMap();

        foreach ($columns as $column) {
            if (isset($map[$column])) {
                $map[$column]($table);
            }
        }
    }

    protected static function appendTouchpointColumns(Blueprint $table, array $columns)
    {
        $map = self::touchpointColumnMap();

        foreach ($columns as $column) {
            if (isset($map[$column])) {
                $map[$column]($table);
            }
        }
    }

    protected static function recordColumnMap()
    {
        return [
            'source_inquiry_id' => function (Blueprint $table) {
                $table->integer('source_inquiry_id')->unsigned()->nullable()->index();
            },
            'request_reference' => function (Blueprint $table) {
                $table->string('request_reference', 120)->nullable()->index();
            },
            'continuity_status' => function (Blueprint $table) {
                $table->string('continuity_status', 60)->default('draft')->index();
            },
            'loyalty_stage' => function (Blueprint $table) {
                $table->string('loyalty_stage', 60)->default('review')->index();
            },
            'referral_ready' => function (Blueprint $table) {
                $table->boolean('referral_ready')->default(false)->index();
            },
            'return_value_tier' => function (Blueprint $table) {
                $table->string('return_value_tier', 60)->default('watch')->index();
            },
            'next_review_at' => function (Blueprint $table) {
                $table->dateTime('next_review_at')->nullable()->index();
            },
            'last_retention_contact_at' => function (Blueprint $table) {
                $table->dateTime('last_retention_contact_at')->nullable()->index();
            },
            'guest_name' => function (Blueprint $table) {
                $table->string('guest_name', 255)->nullable()->index();
            },
            'guest_email' => function (Blueprint $table) {
                $table->string('guest_email', 255)->nullable()->index();
            },
            'guest_phone' => function (Blueprint $table) {
                $table->string('guest_phone', 80)->nullable();
            },
            'country' => function (Blueprint $table) {
                $table->string('country', 120)->nullable()->index();
            },
            'owner_name' => function (Blueprint $table) {
                $table->string('owner_name', 191)->nullable()->index();
            },
            'created_by' => function (Blueprint $table) {
                $table->string('created_by', 191)->nullable();
            },
            'service_focus_summary' => function (Blueprint $table) {
                $table->text('service_focus_summary')->nullable();
            },
            'source_summary' => function (Blueprint $table) {
                $table->text('source_summary')->nullable();
            },
            'continuity_summary' => function (Blueprint $table) {
                $table->text('continuity_summary')->nullable();
            },
            'retention_notes' => function (Blueprint $table) {
                $table->text('retention_notes')->nullable();
            },
            'preferred_season' => function (Blueprint $table) {
                $table->string('preferred_season', 120)->nullable();
            },
            'revisit_window' => function (Blueprint $table) {
                $table->string('revisit_window', 120)->nullable();
            },
            'last_visit_at' => function (Blueprint $table) {
                $table->dateTime('last_visit_at')->nullable()->index();
            },
            'tags_json' => function (Blueprint $table) {
                $table->text('tags_json')->nullable();
            },
            'payload_json' => function (Blueprint $table) {
                $table->longText('payload_json')->nullable();
            },
        ];
    }

    protected static function touchpointColumnMap()
    {
        return [
            'loyalty_record_id' => function (Blueprint $table) {
                $table->integer('loyalty_record_id')->unsigned()->nullable()->index();
            },
            'source_inquiry_id' => function (Blueprint $table) {
                $table->integer('source_inquiry_id')->unsigned()->nullable()->index();
            },
            'touchpoint_type' => function (Blueprint $table) {
                $table->string('touchpoint_type', 60)->default('internal')->index();
            },
            'touchpoint_channel' => function (Blueprint $table) {
                $table->string('touchpoint_channel', 60)->default('system')->index();
            },
            'touchpoint_outcome' => function (Blueprint $table) {
                $table->string('touchpoint_outcome', 100)->default('note_added')->index();
            },
            'touchpoint_at' => function (Blueprint $table) {
                $table->dateTime('touchpoint_at')->nullable()->index();
            },
            'next_step_at' => function (Blueprint $table) {
                $table->dateTime('next_step_at')->nullable()->index();
            },
            'author_name' => function (Blueprint $table) {
                $table->string('author_name', 191)->nullable();
            },
            'operator_name' => function (Blueprint $table) {
                $table->string('operator_name', 191)->nullable()->index();
            },
            'reference_code' => function (Blueprint $table) {
                $table->string('reference_code', 120)->nullable()->index();
            },
            'body' => function (Blueprint $table) {
                $table->text('body')->nullable();
            },
            'touchpoint_summary' => function (Blueprint $table) {
                $table->text('touchpoint_summary')->nullable();
            },
            'is_internal' => function (Blueprint $table) {
                $table->boolean('is_internal')->default(true)->index();
            },
            'payload_json' => function (Blueprint $table) {
                $table->longText('payload_json')->nullable();
            },
        ];
    }
}
