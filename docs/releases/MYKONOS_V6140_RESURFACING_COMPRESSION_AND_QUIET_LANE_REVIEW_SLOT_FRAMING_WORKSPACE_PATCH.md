# Mykonos v6.14.0 Resurfacing Compression and Quiet-Lane Review-Slot Framing Workspace Patch

## Package
- `mykonos-cabnet-v6.14.0-resurfacing-compression-and-quiet-lane-review-slot-framing-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `resurfacing_compression_label`
  - `quiet_lane_review_slot_label`
  - `resurfacing_compression_digest`
  - `quiet_lane_review_slot_frame`
- added new overview panel:
  - `Resurfacing Compression and Quiet-Lane Review Slot`
- extended the linked inquiry loyalty snapshot with:
  - `Resurface compression`
  - `Review slot`
- added list-level scan columns for:
  - `Resurface Compression`
  - `Review Slot`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.28`

## Why this patch matters
The loyalty workspace could already show cadence compression and quiet-lane resurfacing priority.

The remaining friction was review-slot clarity: operators could see that a quiet lane should surface, but still had to mentally rebuild which actual human review slot it belonged to.

This patch keeps the workspace narrow and operator-owned while making quiet resurfacing easier to scan:
- one compressed resurfacing cue
- one explicit quiet review-slot cue
- mirrored visibility on the overview, list, and linked inquiry snapshot
- no theme drift
- no schema drift
- no automation

## Install
1. Upload the zip contents into `/home/cabnet/public_html/`
2. Confirm files land under `mykonos.cabnet.app/...`
3. No `php artisan plugin:refresh Cabnet.MykonosInquiry` is required
4. Clear cache only if backend output appears stale

## Notes
- plugin-only patch
- no schema change
- no public `/plan` change
- continues from the guarded loyalty continuity workspace line
