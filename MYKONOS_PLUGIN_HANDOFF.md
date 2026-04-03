# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed.
- The loyalty line now includes a guarded inquiry-side bridge, a dry-run transfer packet, readiness scoring, the first staged touchpoint-history ledger packet, and outcome/timing planning for future continuity execution.

## This patch
- Version: `v4.7.0`
- Name: `loyalty touchpoint outcomes and next-contact window workspace`
- Type: plugin-only major patch
- Adds staged outcome and timing planning panels for future loyalty touchpoint execution
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_touchpoint_ledger_packet_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_touchpoint_outcome_taxonomy_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_next_contact_window_matrix_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_retention_history_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `plugins/cabnet/mykonosinquiry/updates/create_loyalty_records_table.php`
- `plugins/cabnet/mykonosinquiry/updates/create_loyalty_touchpoints_table.php`
- `docs/releases/MYKONOS_V470_LOYALTY_TOUCHPOINT_OUTCOMES_AND_NEXT_CONTACT_WINDOW_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty bridge line already defined how a closed inquiry could be reviewed for continuity transfer and how staged touchpoint history could eventually be preserved. The next safe step was to define a compact outcome taxonomy and a next-contact window matrix so the first activation wave can classify what happened and when, without pushing the live inquiry queue into long-cycle campaign behavior.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Treat the loyalty touchpoint ledger, outcome taxonomy, and next-contact window matrix as staged activation assets, not activation triggers by themselves.
- Next major patches should focus on guarded touchpoint outcome entry surfaces and the first real loyalty record execution fields once activation is intentionally executed.
