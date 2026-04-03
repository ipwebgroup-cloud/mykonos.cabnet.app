# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity now renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is currently running in a guarded launch-readiness mode.

## This patch
- Version: `v2.4.0`
- Name: `loyalty launch readiness workspace`
- Type: plugin-only operator-facing major patch
- No schema change
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `docs/releases/MYKONOS_V240_LOYALTY_LAUNCH_READINESS_WORKSPACE_PATCH.md`

## Why this patch exists
The guarded workspace was stable again, but it still behaved like a placeholder. This patch turns Loyalty Continuity into a structured pre-launch workspace with clearer readiness, routing, and operator guidance while the storage layer remains deferred.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue using plugin-only operator-facing polish.
- Prepare the loyalty storage layer separately in a controlled, explicitly installable release.
