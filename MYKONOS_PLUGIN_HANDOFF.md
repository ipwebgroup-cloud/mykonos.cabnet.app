# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, first-wave qualification, and timing-guidance surface rather than a placeholder.

## This patch
- Version: `v2.8.0`
- Name: `loyalty first-wave qualification workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_first_wave_qualification_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_retention_timing_windows_panel.htm`
- `docs/releases/MYKONOS_V280_LOYALTY_FIRST_WAVE_QUALIFICATION_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace was already stable and informative, but it still needed a clearer way to define the safest first live cohort once storage is eventually activated. This patch adds first-wave qualification and timing guidance so activation planning can become narrower and more operationally useful without enabling storage yet.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, timing, evidence, and separation panels to define a very narrow first live cohort.
- Add the loyalty tables only in a separate, explicitly installable structural release.
