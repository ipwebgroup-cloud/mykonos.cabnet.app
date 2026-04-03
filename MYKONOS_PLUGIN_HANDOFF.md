# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, and handoff-evidence surface rather than a placeholder.

## This patch
- Version: `v2.7.0`
- Name: `loyalty handoff evidence workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_handoff_evidence_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_workspace_separation_rules_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_activation_readiness_checklist_panel.htm`
- `docs/releases/MYKONOS_V270_LOYALTY_HANDOFF_EVIDENCE_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace had become stable and informative, but it still needed clearer operator-facing proof points for when a case should remain in Inquiry Queue versus when it should later qualify for continuity. This patch adds handoff evidence, separation rules, and readiness checks without activating storage yet.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the evidence and separation panels to define a narrower first activation cohort.
- Add the loyalty tables only in a separate, explicitly installable structural release.
