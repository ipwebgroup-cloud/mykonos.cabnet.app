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
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, compressed finish-watch queue cues, conservative finish-close / reopen scan-order cues, explicit close-handoff grouping with finish-review exit readability, explicit finish-lane handback with post-close hold framing, and explicit hold-release framing with quiet-lane return visibility.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.8.0`
- Name: `hold-release framing and quiet-lane return visibility workspace`
- Type: plugin-only major patch
- Adds one narrow hold-release cue and one explicit quiet-lane return cue so operators can see when a quiet close hold should end and where the lane should return next
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_hold_release_quiet_lane_return_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V680_HOLD_RELEASE_FRAMING_AND_QUIET_LANE_RETURN_VISIBILITY_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch exists
The loyalty line could already show finish handback, post-close hold, close handoff, and finish-review exit.

The remaining friction was the quiet hold itself: operators could see that a record was sitting in a conservative post-close posture, but still had to infer when that hold should end and which lane it should return to next.

This patch makes that easier by:
- introducing one compressed hold-release signal
- introducing one explicit quiet-lane return cue
- surfacing both signals in the overview, list scanning, and linked inquiry snapshot
- keeping the workspace human-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep close, hold, and reopen framing deliberate and non-automated.
- Next major patches should focus on conservative hold-aging readability and quiet-return review timing without drifting into campaign logic, theme work, or automation.
