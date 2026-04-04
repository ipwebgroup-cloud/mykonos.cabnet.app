# Mykonos v6.39.1 Loyalty Workspace Schema Activation Sync Patch

## Package
- `mykonos-cabnet-v6.39.1-loyalty-workspace-schema-activation-sync-patch.zip`

## Why this patch exists
The guarded Loyalty Continuity backend shell can render even when the loyalty storage tables are missing.
In that state, the backend shows the activation-safe fallback page instead of the live continuity workspace.

The current plugin `version.yaml` already references the historical loyalty activation migration files:
- `create_loyalty_records_table.php`
- `create_loyalty_touchpoints_table.php`
- `upgrade_loyalty_records_table_for_workspace_activation.php`
- `upgrade_loyalty_touchpoints_table_for_workspace_activation.php`

This patch restores those files and also adds a forward-only safety migration:
- `ensure_loyalty_workspace_activation_schema.php`

That extra sync migration matters for installations that already advanced beyond the early `2.3.0` to `2.3.3` versions in version history but still do not have the actual loyalty tables/columns installed.

## What changed
- restored the four historical loyalty activation migration files under `plugins/cabnet/mykonosinquiry/updates`
- added `LoyaltyWorkspaceSchema.php` helper so the table/column contract is defined in one place
- added `2.3.54` to `updates/version.yaml`
- added `ensure_loyalty_workspace_activation_schema.php` as a forward-only table/column sync migration
- updated continuity files to mark activation sync as the immediate next operational step

## Install
1. Upload the rooted zip into `/home/cabnet/public_html/`
2. Confirm files extract under `mykonos.cabnet.app/...`
3. From the October root run:
   - `php artisan october:up`
   - or `php artisan october:migrate` if that is the command exposed by the install
4. Clear cache if needed:
   - `php artisan cache:clear`

## Important note
This patch is designed to avoid making `plugin:refresh Cabnet.MykonosInquiry` the first production move.
A refresh can be destructive for the live plugin database footprint.

The forward-only `2.3.54` migration is included specifically so advanced installations can activate the loyalty workspace by running the normal migration command instead of rebuilding the whole plugin.

## Verify
- Backend → Mykonos Inquiries → Loyalty Continuity should stop showing the guarded “missing / upgrade needed” shell
- loyalty tables should exist:
  - `cabnet_mykonos_loyalty_records`
  - `cabnet_mykonos_loyalty_touchpoints`
- the live loyalty workspace should render once the schema is present
