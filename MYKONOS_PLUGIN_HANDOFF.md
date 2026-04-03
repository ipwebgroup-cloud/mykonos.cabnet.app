# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.
- The public plan bridge still depends on the plugin-backed component path remaining healthy, including the backward-compatible `MykonosPlanBridge` alias wrapper.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity is active as a guarded plugin-only workspace and can operate live when storage is aligned.
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, compressed finish-watch queue cues for faster human review, and conservative finish-close / reopen scan-order cues for faster human list scanning.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.5.0`
- Name: `finish-close compression and reopen scan-order cues workspace`
- Type: plugin-only major patch
- Adds a compressed finish-close signal and a conservative reopen scan-order cue so reopened, due, and quiet records are easier to review from the loyalty record, loyalty list, and linked inquiry snapshot
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_finish_close_reopen_sort_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V650_FINISH_CLOSE_COMPRESSION_AND_REOPEN_SCAN_ORDER_CUES_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The loyalty line could already show finish-watch signals, reopen cues, queue-watch timing, and parked-lane meaning.

The remaining friction was queue ordering on the close side: operators could read the story, but still had to mentally decide which reopened or due record should rise first and which quiet parked hold could stay lower.

This patch makes that easier by:
- introducing one compressed finish-close signal and one conservative reopen scan-order cue
- adding a dedicated read-only Overview panel for the new close-side queue readout
- surfacing the same compressed framing on the loyalty list and linked inquiry snapshot
- keeping the workspace narrow, operator-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep reopen framing deliberate and non-automated.
- Next major patches should focus on conservative close-handoff grouping and finish-review exit readability without drifting into campaign logic, theme work, or automation.
