# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, segmentation, treatment-lane, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, and return-value planning surface rather than a placeholder.

## This patch
- Version: `v3.2.0`
- Name: `loyalty segment strategy and treatment-lane workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_segment_strategy_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_treatment_lane_playbook_panel.htm`
- `docs/releases/MYKONOS_V320_LOYALTY_SEGMENT_STRATEGY_AND_TREATMENT_LANE_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace already described qualification, pilot lanes, intent mapping, offers, cadence, measurement, and return-value signals, but it still needed a clearer bridge between identifying a candidate and deciding how that candidate should actually be handled. This patch adds segment strategy and treatment-lane framing so the first continuity pilot can be shaped around a few explicit lanes instead of broad loyalty ambition.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, segmentation, timing, pilot-lane, intent-mapping, offer, cadence, measurement, and return-value panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
