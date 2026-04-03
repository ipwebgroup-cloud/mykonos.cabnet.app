# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed.
- The loyalty line now includes a guarded inquiry-side bridge layer so operators can evaluate transfer readiness without mixing long-cycle continuity into active concierge handling.

## This patch
- Version: `v4.4.0`
- Name: `loyalty inquiry bridge and transfer staging workspace`
- Type: plugin-only major patch
- No schema change
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_inquiry_transfer_bridge_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_transfer_staging_rules_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `docs/releases/MYKONOS_V440_LOYALTY_INQUIRY_BRIDGE_AND_TRANSFER_STAGING_WORKSPACE_PATCH.md`

## Why this patch exists
The structural activation packet existed, but operators still needed a safer inquiry-side bridge that explains when a record should remain in Inquiry Queue and when it becomes eligible for long-cycle continuity. This patch adds that guarded bridge without forcing activation or turning Loyalty Continuity into the live operating surface.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Treat inquiry-side loyalty cues as guidance until the loyalty storage rollout is explicitly activated.
- Next major patches should focus on first real transfer packet wiring and then touchpoint history once the install path is intentionally executed.
