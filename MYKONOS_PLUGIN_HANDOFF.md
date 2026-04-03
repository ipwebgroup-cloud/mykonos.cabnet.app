# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, segmentation, treatment-lane, journey-state, intervention-matrix, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, return-value, message-framework, channel-priority, trigger-library, and exception-routing planning surface rather than a placeholder.

## This patch
- Version: `v3.5.0`
- Name: `loyalty trigger library and exception-routing workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_trigger_library_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_exception_routing_panel.htm`
- `docs/releases/MYKONOS_V350_LOYALTY_TRIGGER_LIBRARY_AND_EXCEPTION_ROUTING_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace already described qualification, segments, treatment lanes, timing, offers, cadence, measurement, return-value signals,
journey-state, intervention logic, message framing, and channel priority, but the first real continuity pilot will also depend on clear trigger discipline
and safe exception-routing. This patch adds a trigger library and exception-routing panel so operators know both when continuity should start and when it should deliberately not start.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, journey-state, intervention, segmentation, timing, pilot-lane, intent-mapping, offer, cadence, measurement, return-value, message-framework, channel-priority, trigger-library, and exception-routing panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
