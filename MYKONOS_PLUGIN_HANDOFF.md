# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, first-wave qualification, timing-guidance, pilot-lane, re-engagement intent, offer-architecture, and cadence-planning surface rather than a placeholder.

## This patch
- Version: `v3.0.0`
- Name: `loyalty offer architecture and cadence workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_offer_architecture_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_reactivation_cadence_panel.htm`
- `docs/releases/MYKONOS_V300_LOYALTY_OFFER_ARCHITECTURE_AND_CADENCE_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace had already clarified pilot lanes and re-engagement intent, but it still needed a more concrete way to map what kind of future continuity offer the team would actually steward and how aggressively that stewardship should be timed. This patch adds offer-architecture and cadence guidance so activation planning becomes more commercially useful without enabling storage yet.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, timing, pilot-lane, intent-mapping, offer-architecture, and cadence panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
