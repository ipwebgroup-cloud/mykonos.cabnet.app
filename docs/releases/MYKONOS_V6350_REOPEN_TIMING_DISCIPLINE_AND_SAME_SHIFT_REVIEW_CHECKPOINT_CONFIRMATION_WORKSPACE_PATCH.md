# Mykonos Loyalty Workspace v6.35.0

## Patch
- `v6.35.0 reopen timing discipline and same-shift review checkpoint confirmation workspace`

## What changed
- added conservative computed loyalty cues:
  - `reopen_timing_discipline_label`
  - `same_shift_review_checkpoint_confirmation_label`
  - `reopen_timing_discipline_digest`
  - `same_shift_review_checkpoint_confirmation_frame`
- added a new loyalty overview panel for reopen timing and same-shift checkpoint confirmation
- loyalty list now surfaces:
  - `Reopen Timing`
  - `Checkpoint Confirmation`
- linked inquiry loyalty continuity snapshot now shows the same two cues and the supporting digest/frame
- updated continuity files for the verified `v6.35.0` rooted line
- bumped plugin tracking to `2.3.49`

## Why this patch matters
The guarded loyalty line already separated parked-lane posture from front-of-queue work and kept ownership visible.

The next safe refinement was to make timing discipline clearer once a parked lane is approaching or entering the current shift, while also making the same-shift checkpoint explicitly readable across the list, overview workspace, and linked inquiry snapshot.

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
