# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, segmentation, treatment-lane, journey-state, intervention-matrix, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, and return-value planning surface rather than a placeholder.

## This patch
- Version: `v3.3.0`
- Name: `loyalty journey-state and intervention matrix workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_journey_state_framing_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_intervention_matrix_panel.htm`
- `docs/releases/MYKONOS_V330_LOYALTY_JOURNEY_STATE_AND_INTERVENTION_MATRIX_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace already described qualification, segments, treatment lanes, timing, offers, cadence, measurement, and return-value signals,
but operators still needed a clearer way to name where a guest sits in the continuity journey and what kind of intervention is actually appropriate.
This patch adds journey-state framing and a simple intervention matrix so the first loyalty pilot can be shaped around lighter, safer, more consistent moves.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, journey-state, intervention, segmentation, timing, pilot-lane, intent-mapping, offer, cadence, measurement, and return-value panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
