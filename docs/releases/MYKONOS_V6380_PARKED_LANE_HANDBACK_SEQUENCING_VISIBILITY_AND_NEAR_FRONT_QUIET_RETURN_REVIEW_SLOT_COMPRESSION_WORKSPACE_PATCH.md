# Mykonos Loyalty Workspace v6.38.0

## Patch
- `v6.38.0 parked-lane handback sequencing visibility and near-front quiet-return review-slot compression workspace`

## What changed
- added conservative computed loyalty cues:
  - `parked_lane_handback_sequencing_visibility_label`
  - `near_front_quiet_return_review_slot_compression_label`
  - `parked_lane_handback_sequencing_visibility_digest`
  - `near_front_quiet_return_review_slot_compression_frame`
- added a new loyalty overview panel for parked-lane handback sequencing visibility and near-front quiet-return review-slot compression
- loyalty list now surfaces:
  - `Handback Sequence`
  - `Near-Front Slot`
- linked inquiry loyalty continuity snapshot now shows the same two cues plus the supporting digest/frame
- updated continuity files for the verified `v6.38.0` rooted line
- bumped plugin tracking to `2.3.52`

## Why this patch matters
The guarded loyalty line already made deferred owner-slot alignment and quiet-return shift separation easier to scan.

The next safe refinement was to make it clearer whether a parked quiet return already has a believable handback order and whether that return should compress into a near-front review slot or remain staged for later, without widening the workflow into automation or changing the `/plan` bridge.

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
