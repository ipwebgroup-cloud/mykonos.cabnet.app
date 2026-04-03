# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.
- The public plan bridge still depends on the plugin-backed component path remaining healthy, including the backward-compatible `MykonosPlanBridge` alias wrapper.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity is active as a guarded plugin-only workspace and can operate live when storage is aligned.
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, compressed finish-watch queue cues, conservative finish-close / reopen scan-order cues, and explicit close-handoff grouping with finish-review exit readability.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.6.0`
- Name: `close-handoff grouping and finish-review exit readability workspace`
- Type: plugin-only major patch
- Adds a narrow close handoff group and a clean finish-review exit cue so operators can classify close-side records and read the next safe exit without mentally rebuilding the finish lane
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_close_handoff_review_exit_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V660_CLOSE_HANDOFF_GROUPING_AND_FINISH_REVIEW_EXIT_READABILITY_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The loyalty line could already show finish-close posture, reopen ordering, parked watch timing, and finish-watch meaning.

The remaining friction was the close-side handoff decision itself: operators could read the signals, but still had to reconstruct what group the record belonged to and what the clean exit from finish review should be.

This patch makes that easier by:
- introducing one compressed close handoff group and one explicit finish-review exit cue
- adding a dedicated Overview panel for the new close-side handoff readout
- surfacing the same framing on the loyalty list and linked inquiry snapshot
- keeping the workspace narrow, operator-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep close and reopen framing deliberate and non-automated.
- Next major patches should focus on conservative finish-lane handback readability and explicit post-close hold framing without drifting into campaign logic, theme work, or automation.
