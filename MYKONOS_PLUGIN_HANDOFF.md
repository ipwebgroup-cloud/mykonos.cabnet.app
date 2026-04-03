# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.
- The public plan bridge still depends on the plugin-backed component path remaining healthy, including the backward-compatible `MykonosPlanBridge` alias wrapper.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity is active as a guarded plugin-only workspace and can operate live when storage is aligned.
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, and queue-watch / deliberate reopen-priority framing for faster human review.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.

## This patch
- Version: `v6.3.0`
- Name: `queue watch readability and deliberate reopen priority framing workspace`
- Type: plugin-only major patch
- Adds a read-only watch-timing and reopen-priority layer so reopened lanes and due parked watches surface faster from the loyalty record, loyalty list, and linked inquiry snapshot
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_queue_watch_reopen_priority_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V630_QUEUE_WATCH_READABILITY_AND_DELIBERATE_REOPEN_PRIORITY_FRAMING_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The loyalty line could already compress queue posture and show parked-lane meaning.

The remaining friction was queue-watch timing: reopened lanes and due parked windows were readable, but they did not rise quite fast enough in the human review story.

This patch makes that easier by:
- introducing queue-watch readiness and deliberate reopen-priority signals
- adding a dedicated read-only overview panel for parked watch timing and reopen pressure
- surfacing the same compressed watch framing on the loyalty list and linked inquiry snapshot
- keeping the workspace narrow, operator-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep reopen framing deliberate and non-automated.
- Next major patches should focus on conservative reopen-lane triage polish and finish-watch dashboard compression without drifting into campaign logic, theme work, or automation.
