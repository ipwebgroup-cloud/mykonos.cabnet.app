# Mykonos Loyalty Workspace v6.37.0

## Patch
- `v6.37.0 owner-visible deferred review-slot alignment and current-shift versus next-shift quiet-return separation workspace`

## What changed
- added conservative computed loyalty cues:
  - `owner_visible_deferred_review_slot_alignment_label`
  - `current_shift_next_shift_quiet_return_separation_label`
  - `owner_visible_deferred_review_slot_alignment_digest`
  - `current_shift_next_shift_quiet_return_separation_frame`
- added a new loyalty overview panel for owner-visible deferred review-slot alignment and quiet-return shift separation
- loyalty list now surfaces:
  - `Deferred Slot Alignment`
  - `Quiet-Return Shift Split`
- linked inquiry loyalty continuity snapshot now shows the same two cues plus the supporting digest/frame
- updated continuity files for the verified `v6.37.0` rooted line
- bumped plugin tracking to `2.3.51`

## Why this patch matters
The guarded loyalty line already made parked-lane owner reassignment and front-of-list quiet-return confirmation easier to scan.

The next safe refinement was to make it clearer when a deferred quiet-return slot is credibly aligned to a named owner and whether that return belongs to the current shift, the next shift, or a later parked window, without widening the workflow into automation or changing the `/plan` bridge.

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
