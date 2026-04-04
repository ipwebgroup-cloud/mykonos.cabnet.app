# Mykonos Loyalty Workspace v6.39.0

## Patch
- `v6.39.0 owner-held next-shift handback confirmation and current-lane versus deferred-lane return compression workspace`

## What changed
- added conservative computed loyalty cues:
  - `owner_held_next_shift_handback_confirmation_label`
  - `current_lane_deferred_lane_return_compression_label`
  - `owner_held_next_shift_handback_confirmation_digest`
  - `current_lane_deferred_lane_return_compression_frame`
- added a new loyalty overview panel for owner-held next-shift handback confirmation and current-lane versus deferred-lane return compression
- loyalty list now surfaces:
  - `Next-Shift Handback`
  - `Lane Return Compression`
- linked inquiry loyalty continuity snapshot now shows the same two cues plus the supporting digest/frame
- updated continuity files for the verified `v6.39.0` rooted line
- bumped plugin tracking to `2.3.53`

## Why this patch matters
The guarded loyalty line already made parked handback sequencing and near-front quiet-return slotting easier to scan.

The next safe refinement was to make it clearer whether a parked quiet return already has a believable owner-held next-shift handback and whether that return should compress into the current lane now or remain in a deferred lane, without widening the workflow into automation or changing the `/plan` bridge.

This stays plugin-only, render-safe, and does not disturb `/plan` or the live Inquiry Queue workflow.

## Install
1. Upload the rooted patch files into `/home/cabnet/public_html/`
2. Keep the extracted paths under `mykonos.cabnet.app/...`
3. No `php artisan plugin:refresh Cabnet.MykonosInquiry` is required
4. Clear cache only if backend output looks stale:
   - `php artisan cache:clear`

## Notes
- no schema change
- no migration
- no theme change
- continuity files were updated together with the patch
