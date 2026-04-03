# Mykonos Loyalty Workspace v6.5.0 Finish-Close Compression and Reopen Scan-Order Cues Patch

## Patch summary
- Version: `v6.5.0`
- Type: plugin-only workspace refinement
- Schema change: no
- Theme change: no

## What changed
This patch continues directly from the real `v6.4.0` line.

The loyalty workspace could already show finish-watch signals, reopen cues, queue-watch timing, and deliberate reopen priority.

The remaining friction was close-side queue ordering: operators could understand the finish story, but still had to mentally compress which records should be scanned first when the queue mixes reopened lanes, due parked lanes, unfinished close packets, and quiet parked holds.

This patch adds:
- a new read-only `Finish-Close Signal`
- a conservative `Reopen Scan Order` cue with a human-readable numeric prefix
- a new `Finish-Close Compression and Reopen Scan Order` overview panel
- compressed close-side digest and framing fields on the loyalty record
- the same finish-close and reopen-order cues on the linked inquiry loyalty snapshot
- new list columns for finish-close and reopen-order visibility

## Why this patch exists
The queue already had readable finish posture.

What it still lacked was a tighter close-side compression and a safe, non-automated way to show which reopen-sensitive records deserve earlier human scanning.

This patch solves that with read-only operator cues only. It does not change schema, it does not automate actions, and it does not widen the public `/plan` bridge or the live Inquiry Queue.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_finish_close_reopen_sort_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V650_FINISH_CLOSE_COMPRESSION_AND_REOPEN_SCAN_ORDER_CUES_WORKSPACE_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Install
1. Upload the changed rooted files into `/home/cabnet/public_html/`
2. No `plugin:refresh` is required
3. Clear cache only if backend partial output appears stale

## Verification
1. Open backend → **Loyalty Continuity**
2. Confirm the list can show the new `Finish-Close` and `Reopen Order` cues
3. Open a loyalty record and confirm the new `Finish-Close Compression and Reopen Scan Order` panel renders
4. Open a linked inquiry and confirm the loyalty snapshot includes the same cues

## Safety notes
- plugin-only
- no migrations
- no public theme changes
- no automation
- no queue mutation logic
