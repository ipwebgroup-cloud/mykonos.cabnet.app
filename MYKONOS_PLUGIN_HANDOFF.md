# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, first-wave qualification, timing-guidance, pilot-lane, and re-engagement intent surface rather than a placeholder.

## This patch
- Version: `v2.9.0`
- Name: `loyalty pilot-lane and intent mapping workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_pilot_candidate_lanes_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_reengagement_intent_map_panel.htm`
- `docs/releases/MYKONOS_V290_LOYALTY_PILOT_LANE_AND_INTENT_MAPPING_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace had already clarified activation timing, evidence, and first-wave qualification, but it still needed a clearer way to define which candidate lanes should be used in the first live pilot and what kind of future re-engagement intent each candidate actually represents. This patch adds pilot-lane and intent-mapping guidance so activation planning becomes narrower, cleaner, and more operationally meaningful without enabling storage yet.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, timing, pilot-lane, and intent-mapping panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
