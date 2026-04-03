# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning and activation-blueprint surface rather than a placeholder.

## This patch
- Version: `v2.6.0`
- Name: `loyalty transition scorecard workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_activation_gates_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_safe_rollout_plan_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_operator_routes_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_transition_scorecard_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_activation_scenarios_panel.htm`
- `docs/releases/MYKONOS_V260_LOYALTY_TRANSITION_SCORECARD_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace was stable again, but it still mostly explained that the data layer was missing. This patch expands the area into a more practical operator-facing transition workspace with a continuity scorecard and activation scenarios while the storage layer remains deferred.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the scorecard and scenario panels to prepare a cleaner first storage release.
- Add the loyalty tables only in a separate, explicitly installable structural release.
