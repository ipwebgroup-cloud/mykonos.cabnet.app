# Mykonos Loyalty Workspace v6.36.0

## Patch
- `v6.36.0 parked-lane owner reassignment visibility and front-of-list quiet-return confirmation workspace`

## What changed
- added conservative computed loyalty cues:
  - `parked_lane_owner_reassignment_visibility_label`
  - `front_of_list_quiet_return_confirmation_label`
  - `parked_lane_owner_reassignment_visibility_digest`
  - `front_of_list_quiet_return_confirmation_frame`
- added a new loyalty overview panel for parked-lane owner reassignment and front-of-list quiet-return confirmation
- loyalty list now surfaces:
  - `Owner Reassignment`
  - `Front-of-List Return`
- linked inquiry loyalty continuity snapshot now shows the same two cues plus the supporting digest/frame
- updated continuity files for the verified `v6.36.0` rooted line
- bumped plugin tracking to `2.3.50`

## Why this patch matters
The guarded loyalty line already made reopen timing, same-shift checkpoint confirmation, queue separation, and owner-state handoff more readable.

The next safe refinement was to make it clearer when a parked lane still needs ownership reassignment and when a quiet return now belongs near the very front of human review, without widening the workflow into automation or changing the `/plan` bridge.

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
