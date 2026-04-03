# Mykonos Inquiry Plugin v2.3.11 Loyalty Workspace Table Guard Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.11-loyalty-workspace-table-guard-public-html-rooted.zip`

## What changed
- plugin-only patch
- no schema change
- no theme change
- guards the Loyalty Continuity backend controller views when the loyalty table does not exist yet
- prevents the loyalty list, create, and update screens from crashing on direct table access
- preserves both toolbar partial names used by the live workspace
- updates the root handoff file for crash recovery continuity

## Why this patch matters
The loyalty workspace route had progressed beyond earlier render failures, but the live environment still does not have the `cabnet_mykonos_loyalty_records` table.

Instead of allowing the list and form views to execute against a missing table, this patch renders a controlled operator message and keeps the broader inquiry workspace stable.

## Included files
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`
