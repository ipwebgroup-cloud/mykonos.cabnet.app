# Mykonos Loyalty Workspace v6.34.0

## Patch
- `v6.34.0 front-of-queue versus parked-lane separation and owner-state handoff compression workspace`

## What changed
- added conservative computed loyalty cues:
  - `front_of_queue_parked_lane_separation_label`
  - `owner_state_handoff_compression_label`
  - `front_of_queue_parked_lane_separation_digest`
  - `owner_state_handoff_compression_frame`
- added a new loyalty overview panel for queue separation and owner-state handoff compression
- loyalty list now surfaces:
  - `Queue Separation`
  - `Owner-State Handoff`
- linked inquiry loyalty continuity snapshot now shows the same two cues and the supporting digest/frame
- updated continuity files for the verified `v6.34.0` rooted line
- bumped plugin tracking to `2.3.48`

## Why this patch matters
The current guarded loyalty line already translated quiet-lane and queue posture into operator-readable scan cues.

The next safe refinement was to separate records that truly belong at the front of human review from records that can still live credibly in a parked lane, while also keeping owner handoff state visible when a record moves between those postures.

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
