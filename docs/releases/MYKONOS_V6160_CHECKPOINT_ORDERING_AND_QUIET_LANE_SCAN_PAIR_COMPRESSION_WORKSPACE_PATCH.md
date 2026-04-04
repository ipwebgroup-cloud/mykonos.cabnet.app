# Mykonos v6.16.0 Checkpoint Ordering and Quiet-Lane Scan-Pair Compression Workspace Patch

## Package
- `mykonos-cabnet-v6.16.0-checkpoint-ordering-and-quiet-lane-scan-pair-compression-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `checkpoint_ordering_label`
  - `quiet_lane_scan_pair_compression_label`
  - `checkpoint_ordering_digest`
  - `quiet_lane_scan_pair_compression_frame`
- added new overview panel:
  - `Checkpoint Ordering and Quiet-Lane Scan-Pair Compression`
- compressed the loyalty continuity list by replacing the previous grouped quiet-lane pair with two list-friendly cues:
  - `Checkpoint Order`
  - `Scan Pair`
- updated the linked inquiry loyalty snapshot so the prior grouped pair is now shown as:
  - `Checkpoint ordering`
  - `Quiet-lane scan pair`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.30`

## Why this patch matters
The loyalty workspace could already compress the quiet review slot and the resurfacing cadence into a narrower read.

The remaining friction was cross-surface regrouping. Operators still had to mentally translate that grouped quiet-lane read between:
- the loyalty list
- the loyalty overview workspace
- the linked inquiry snapshot

This patch keeps the workspace narrow and operator-owned while reducing that translation burden again:
- one ordered checkpoint cue
- one list/detail scan-pair cue
- a dedicated overview panel
- a cleaner linked inquiry loyalty snapshot
- a more list-friendly loyalty queue read
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
