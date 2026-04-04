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
- Loyalty records now support transfer bridging, live touchpoint capture, continuity decision framing, retention packet preparation, packet follow-through execution framing, closing-loop readability, explicit stewardship closure packets, outcome-driven finish recommendations, explicit finish-lane parking/reopening, parked-state digest framing, finish dashboards, finish triage compression, conservative queue-scan aids, queue-watch / deliberate reopen-priority framing, compressed finish-watch queue cues, conservative finish-close / reopen scan-order cues, explicit close-handoff grouping with finish-review exit readability, explicit finish-lane handback with post-close hold framing, explicit hold-release framing with quiet-lane return visibility, conservative hold-aging readability with quiet-return review timing, and compressed hold-aging with quiet-lane re-entry readiness, plus conservative hold-expiry grouping with explicit quiet-lane re-entry ordering.
- The guarded non-ready loyalty index, create, and update views tolerate missing staged partials instead of assuming every historical staging partial is present.
- The loyalty workspace now includes explicit hold-expiry compression and quiet-lane cadence framing so quiet close holds can be scanned without reconstructing timing manually, plus cadence compression with explicit quiet-lane resurfacing priority.

## This patch
- Version: `v6.13.0`
- Name: `cadence compression and quiet-lane resurfacing priority workspace`
- Type: plugin-only major patch
- Adds one stronger cadence-compression cue and one explicit quiet-lane resurfacing priority cue so operators can see which quiet hold should surface first without mentally rebuilding queue order
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_cadence_compression_quiet_resurfacing_priority_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V6130_CADENCE_COMPRESSION_AND_QUIET_LANE_RESURFACING_PRIORITY_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch exists
The loyalty line could already show hold-expiry compression and quiet-lane cadence.

The remaining friction was resurfacing order clarity: operators could read how quietly a hold should age, but still had to mentally rebuild which quiet lane should surface first once several conservative holds sat together in the queue.

This patch makes that easier by:
- introducing one stronger cadence-compression cue and one explicit quiet-lane resurfacing priority cue
- adding a dedicated Overview panel for the new compression/priority readout
- surfacing the same framing on the loyalty list and linked inquiry snapshot
- keeping the workspace narrow, operator-owned, plugin-only, and non-automated

## Safest next direction
- Keep Inquiry Queue stable as the live operational workspace.
- Keep loyalty continuity narrow, operator-owned, and readable.
- Keep close, hold, and reopen framing deliberate and non-automated.
- Next major patches should focus on conservative resurfacing compression and quiet-lane review-slot framing without drifting into campaign logic, theme work, or automation.
