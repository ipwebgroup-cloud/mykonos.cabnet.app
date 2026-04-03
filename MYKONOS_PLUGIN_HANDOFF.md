# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, and return-value planning surface rather than a placeholder.

## This patch
- Version: `v3.1.0`
- Name: `loyalty measurement and return-value workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_measurement_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_return_value_signals_panel.htm`
- `docs/releases/MYKONOS_V310_LOYALTY_MEASUREMENT_AND_RETURN_VALUE_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace had already clarified qualification, pilot lanes, intent mapping, offers, and cadence, but it still needed a cleaner way to judge whether a narrow continuity pilot would be measurable and commercially worthwhile. This patch adds continuity measurement and return-value framing so activation planning can be evaluated more decisively without turning on storage yet.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, timing, pilot-lane, intent-mapping, offer, cadence, measurement, and return-value panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
