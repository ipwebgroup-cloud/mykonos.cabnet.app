# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.
- The public plan bridge still depends on the plugin-backed component path remaining healthy, including the backward-compatible `MykonosPlanBridge` alias wrapper.
- Keep the reusable new-chat launcher at `MYKONOS_CONTINUE_PROMPT.md` in sync with this handoff file.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity is active as a guarded plugin-only workspace and can operate live when storage is aligned.
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, compressed finish-watch queue cues, conservative finish-close / reopen scan-order cues, explicit close-handoff grouping with finish-review exit readability, explicit finish-lane handback with post-close hold framing, explicit hold-release framing with quiet-lane return visibility, and conservative hold-aging readability with quiet-return review timing.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.9.0`
- Name: `hold-aging readability and quiet-return review timing workspace`
- Type: plugin-only major patch
- Adds one narrow hold-aging cue and one explicit quiet-return review-timing cue so operators can see whether a quiet close hold is still fresh, maturing, stable, or already aged out into active review
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_hold_aging_quiet_return_timing_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V690_HOLD_AGING_READABILITY_AND_QUIET_RETURN_REVIEW_TIMING_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch exists
The loyalty line could already show hold release, quiet-lane return, finish handback, and post-close hold posture.

The remaining friction was the aging of the quiet hold itself: operators could see that a record was resting conservatively, but still had to infer whether the hold was still fresh, quietly maturing, stable for later review, or already aged out into active human timing.

This patch makes that easier by:
- introducing one compressed hold-aging cue and one explicit quiet-return review-timing cue
- adding a dedicated Overview panel for the new hold/timing readout
- surfacing the same framing on the loyalty list and linked inquiry snapshot
- keeping the workspace narrow, operator-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep close, hold, and reopen framing deliberate and non-automated.
- Next major patches should focus on conservative hold-aging readability and quiet-return review timing without drifting into campaign logic, theme work, or automation.
