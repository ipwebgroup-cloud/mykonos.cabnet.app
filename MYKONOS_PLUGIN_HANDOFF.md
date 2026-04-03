# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed or only partially installed.
- The loyalty line now includes a guarded inquiry-side bridge, dry-run transfer scoring, staged loyalty record and touchpoint schema packets, outcome/timing planning, the first staged touchpoint outcome entry and execution field surfaces, and a schema-aligned activation path for deliberate live transfer.

## This patch
- Version: `v4.9.0`
- Name: `loyalty activation schema alignment and explicit transfer wiring`
- Type: plugin-only major patch
- Adds schema-readiness guards, non-destructive loyalty activation upgrades, direct inquiry-to-loyalty record opening, and read-only loyalty detail structure panels
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/Inquiries.php`
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_record_detail_structure_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_transfer_audit_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyTouchpoint.php`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `plugins/cabnet/mykonosinquiry/updates/upgrade_loyalty_records_table_for_workspace_activation.php`
- `plugins/cabnet/mykonosinquiry/updates/upgrade_loyalty_touchpoints_table_for_workspace_activation.php`
- `docs/releases/MYKONOS_V490_LOYALTY_ACTIVATION_SCHEMA_AND_TRANSFER_WIRING_PATCH.md`

## Why this patch exists
The loyalty workspace UI had advanced further than the original staged activation migrations. In practice, the plugin could show a loyalty area that looked close to activation while the underlying staged tables still lacked the columns required by the real live workspace model.

This patch closes that gap safely:
- it keeps backend rendering guarded
- it makes the install state explicit
- it aligns the loyalty tables non-destructively
- it turns the inquiry-side transfer button into a real plugin-side create-and-open action once storage is truly ready

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Treat loyalty activation as deliberately gated until `plugin:refresh` has applied the schema-alignment upgrades and the install state reports workspace-ready.
- The next major patch should focus on first live touchpoint capture discipline inside activated loyalty records, using the newly aligned schema rather than adding broader campaign behavior.
