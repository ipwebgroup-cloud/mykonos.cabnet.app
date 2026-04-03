# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed.
- The loyalty line now includes a guarded inquiry-side bridge, a dry-run transfer packet, readiness scoring, and the first staged touchpoint-history ledger packet for future continuity retention tracking.

## This patch
- Version: `v4.6.0`
- Name: `loyalty touchpoint ledger and retention history packet workspace`
- Type: plugin-only major patch
- Adds install-ready schema packet files for loyalty touchpoint history
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_touchpoint_ledger_packet_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_retention_history_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `plugins/cabnet/mykonosinquiry/updates/create_loyalty_records_table.php`
- `plugins/cabnet/mykonosinquiry/updates/create_loyalty_touchpoints_table.php`
- `docs/releases/MYKONOS_V460_LOYALTY_TOUCHPOINT_LEDGER_AND_RETENTION_HISTORY_PACKET_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty bridge line already defined how a closed inquiry could be reviewed for continuity transfer. The next safe structural step was to stage the first touchpoint-history ledger so the future Loyalty Continuity rollout can preserve retention evidence, outcomes, and next-step timing without turning the current inquiry queue into a CRM-style long-cycle timeline.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Treat the loyalty touchpoint ledger as an install-ready packet, not an activation trigger by itself.
- Next major patches should focus on the first real loyalty record form structure and guarded touchpoint list wiring once activation is intentionally executed.
