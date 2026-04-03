# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity renders safely even when the loyalty storage layer is not installed.
- The loyalty workspace is now operating as a guarded transition-planning, activation-blueprint, scorecard, handoff-evidence, qualification, segmentation, treatment-lane, journey-state, intervention-matrix, timing-guidance, pilot-lane, intent-mapping, offer-architecture, cadence-planning, measurement, return-value, message-framework, channel-priority, trigger-library, exception-routing, escalation-threshold, ownership-matrix, suppression-control, frequency-cap, consent-discipline, approval-checkpoint, cutover-sequence, and post-launch review planning surface rather than a placeholder.

## This patch
- Version: `v4.0.0`
- Name: `loyalty cutover sequence and post-launch review workspace`
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
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_activation_cutover_sequence_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_post_launch_review_guardrails_panel.htm`
- `docs/releases/MYKONOS_V400_LOYALTY_CUTOVER_SEQUENCE_AND_POST_LAUNCH_REVIEW_WORKSPACE_PATCH.md`

## Why this patch exists
The loyalty workspace already defined how a first pilot could be governed and rolled back, but it still needed a clearer operational cutover order and a stricter post-launch review discipline before expansion. This patch adds cutover-sequence and post-launch review panels so activation remains premium, narrow, and explicitly reviewable.

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Continue with plugin-only operator-facing patches until the loyalty storage layer is ready.
- Use the qualification, journey-state, intervention, segmentation, timing, pilot-lane, intent-mapping, offer, cadence, measurement, return-value, message-framework, channel-priority, trigger-library, exception-routing, escalation-threshold, ownership-matrix, suppression-control, frequency-cap, consent-discipline, approval-checkpoint, pilot-experiment-ledger, rollback-criteria, cutover-sequence, and post-launch review panels to define a very narrow first live pilot.
- Add the loyalty tables only in a separate, explicitly installable structural release.
