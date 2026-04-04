# Mykonos v6.17.0 Owner-First Checkpoint Pairing and Quiet-Lane Return Scan Compression Workspace Patch

## Package
- `mykonos-cabnet-v6.17.0-owner-first-checkpoint-pairing-and-quiet-lane-return-scan-compression-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `owner_first_checkpoint_pairing_label`
  - `quiet_lane_return_scan_compression_label`
  - `owner_first_checkpoint_pairing_digest`
  - `quiet_lane_return_scan_compression_frame`
- added new overview panel:
  - `Owner-First Checkpoint Pairing and Quiet-Lane Return Scan Compression`
- compressed the loyalty continuity list again by replacing the prior ordered scan pair with two narrower operator cues:
  - `Owner Pair`
  - `Return Scan`
- updated the linked inquiry loyalty snapshot so the prior checkpoint/scan pair is now shown as:
  - `Owner-first checkpoint pair`
  - `Quiet-lane return scan`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.31`

## Why this patch matters
The loyalty workspace could already compress checkpoint ordering and the list/detail scan pair into a narrower read.

The remaining friction was still operator ownership at the moment of quiet return. The list cue, overview cue, and linked inquiry snapshot could still read as orderly without making the named owner visible enough when the next quiet checkpoint actually mattered.

This patch keeps the workspace narrow and operator-owned while reducing that last translation step again:
- one owner-first checkpoint cue
- one quiet-lane return scan cue
- a dedicated overview panel
- a cleaner linked inquiry loyalty snapshot
- a more human-first loyalty queue read
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
