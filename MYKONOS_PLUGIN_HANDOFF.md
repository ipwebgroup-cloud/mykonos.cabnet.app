# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, segmentation, treatment-lane, journey-state, intervention-matrix, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, return-value, message-framework, and channel-priority planning surface rather than a placeholder.

## This patch
- Version: `v3.4.0`
- Name: `loyalty message framework and channel priority workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_message_framework_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_channel_priority_map_panel.htm`
- `docs/releases/MYKONOS_V340_LOYALTY_MESSAGE_FRAMEWORK_AND_CHANNEL_PRIORITY_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace already described qualification, segments, treatment lanes, timing, offers, cadence, measurement, return-value signals,
journey-state, and intervention logic, but the first real continuity pilot will also depend on message discipline and channel discipline.
This patch adds a message framework and channel-priority map so the pilot can be shaped around consistent outreach rules before storage activation.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, journey-state, intervention, segmentation, timing, pilot-lane, intent-mapping, offer, cadence, measurement, return-value, message-framework, and channel-priority panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
