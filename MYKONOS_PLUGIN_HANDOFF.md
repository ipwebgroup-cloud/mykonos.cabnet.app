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
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, compressed finish-watch queue cues, conservative finish-close / reopen scan-order cues, explicit close-handoff grouping with finish-review exit readability, and explicit finish-lane handback with post-close hold framing.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.7.0`
- Name: `finish-lane handback readability and explicit post-close hold framing workspace`
- Type: plugin-only major patch
- Adds one narrow finish-lane handback cue and one explicit post-close hold posture so operators can see who the close-side lane should return to and whether it can safely remain in a quiet hold
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_finish_handback_post_close_hold_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V670_FINISH_LANE_HANDBACK_READABILITY_AND_POST_CLOSE_HOLD_FRAMING_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch exists
The loyalty line could already show finish-close posture, reopen ordering, close-side handoff grouping, and finish-review exits.

The remaining friction was the handback itself: even when the close posture was readable, operators still had to infer who or what the finish lane should return to next and whether the record could safely stay in a quiet post-close hold.

This patch makes that easier by:
- introducing one compressed finish-lane handback signal
- introducing one explicit post-close hold posture
- surfacing both signals in the overview, list scanning, and linked inquiry snapshot
- keeping the workspace human-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep close, hold, and reopen framing deliberate and non-automated.
- Next major patches should focus on conservative hold-release framing and quiet-lane return visibility without drifting into campaign logic, theme work, or automation.
