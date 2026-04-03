# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace now includes the first structural activation packet while remaining in guarded pre-launch mode.

## This patch
- Version: `v4.3.0`
- Name: `loyalty structural activation foundation`
- Type: plugin-only major patch
- Introduces the first install-ready loyalty schema packet
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_structural_activation_foundation_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_installable_schema_packet_panel.htm`
- `plugins/cabnet/mykonosinquiry/updates/create_loyalty_records_table.php`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V430_LOYALTY_STRUCTURAL_ACTIVATION_FOUNDATION_PATCH.md`

## Why this patch exists
The Loyalty Continuity line had matured into a strong planning workspace but still lacked the first real structural packet required for a controlled activation. This patch adds that packet without making the loyalty area the live operational queue before an explicit install step.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Treat the loyalty schema packet as staged, not automatically active.
- Next major patches should focus on guarded inquiry-to-loyalty transfer wiring, followed by loyalty list/detail workflow activation and touchpoint history.
