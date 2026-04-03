# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, segmentation, treatment-lane, journey-state, intervention-matrix, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, return-value, message-framework, channel-priority, trigger-library, exception-routing, escalation-threshold, ownership-matrix, suppression-control, frequency-cap, consent-discipline, and approval-checkpoint planning surface rather than a placeholder.

## This patch
- Version: `v3.9.0`
- Name: `loyalty pilot-experiment ledger and rollback criteria workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_pilot_experiment_ledger_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_rollback_criteria_panel.htm`
- `docs/releases/MYKONOS_V390_LOYALTY_PILOT_EXPERIMENT_LEDGER_AND_ROLLBACK_CRITERIA_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace already defined who may qualify, how a pilot could be paced, and where continuity should be suppressed, but it still needed clearer rules for when contact is appropriate at all and how a first live continuity move should be approved. This patch adds consent-discipline and approval-checkpoint panels so the first activation remains premium, deliberate, and defensible.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, journey-state, intervention, segmentation, timing, pilot-lane, intent-mapping, offer, cadence, measurement, return-value, message-framework, channel-priority, trigger-library, exception-routing, escalation-threshold, ownership-matrix, suppression-control, frequency-cap, consent-discipline, approval-checkpoint, pilot-experiment-ledger, and rollback-criteria panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
