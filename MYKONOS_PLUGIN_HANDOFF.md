# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.
- The public plan bridge still depends on the plugin-backed component path remaining healthy, including the backward-compatible `MykonosPlanBridge` alias wrapper.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity is active as a guarded plugin-only workspace and can operate live when storage is aligned.
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, and compressed finish-watch queue cues for faster human review.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.4.0`
- Name: `finish-watch dashboard compression and reopen queue cues workspace`
- Type: plugin-only major patch
- Adds a compressed finish-watch readout so the next queue cue is visible faster from the loyalty record, loyalty list, and linked inquiry snapshot
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_finish_watch_dashboard_compression_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V640_FINISH_WATCH_DASHBOARD_COMPRESSION_AND_REOPEN_QUEUE_CUES_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The loyalty line could already show finish dashboards, queue-watch timing, reopen priority, and parked-lane meaning.

The remaining friction was cognitive compression: operators still had to read several separate labels to understand the single queue cue that mattered most.

This patch makes that easier by:
- introducing one compressed finish-watch signal and one reopen-oriented queue cue
- adding a dedicated read-only Overview panel for the compressed queue readout
- surfacing the same compressed framing on the loyalty list and linked inquiry snapshot
- keeping the workspace narrow, operator-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep reopen framing deliberate and non-automated.
- Next major patches should focus on conservative finish-close compression and list-level reopen sorting cues without drifting into campaign logic, theme work, or automation.
