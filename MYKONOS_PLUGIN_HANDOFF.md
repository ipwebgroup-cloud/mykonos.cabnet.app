# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.
- The public plan bridge still depends on the plugin-backed component path remaining healthy, including the backward-compatible `MykonosPlanBridge` alias wrapper.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity is active as a guarded plugin-only workspace and can operate live when storage is aligned.
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, and conservative queue-scan aids for faster human review.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.2.0`
- Name: `conservative stewardship queue compression and list-scan aids workspace`
- Type: plugin-only major patch
- Adds a conservative queue-compression layer so operators can scan finish-ready, parked, reopened, and quiet-review loyalty records faster from the loyalty record, loyalty list, and linked inquiry snapshot
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_stewardship_queue_scan_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V620_CONSERVATIVE_STEWARDSHIP_QUEUE_COMPRESSION_AND_LIST_SCAN_AIDS_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The loyalty line could already show finish posture, parked-state meaning, and finish triage.

The remaining friction was queue speed: operators could understand a record after opening it, but the queue still lacked a cleaner compressed read of what belongs near the top, what can stay parked quietly, and what should remain in conservative review.

This patch makes that easier by:
- introducing a stewardship queue scan panel on the live loyalty record
- adding queue band, scan aid, and owner-timing signals
- surfacing the same compressed queue read on the loyalty list and linked inquiry snapshot
- keeping finish handling narrow, human-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep queue compression conservative and non-automated.
- Next major patches should focus on queue-watch readability polish and deliberate reopen-priority framing without drifting into campaign logic, theme work, or automation.
