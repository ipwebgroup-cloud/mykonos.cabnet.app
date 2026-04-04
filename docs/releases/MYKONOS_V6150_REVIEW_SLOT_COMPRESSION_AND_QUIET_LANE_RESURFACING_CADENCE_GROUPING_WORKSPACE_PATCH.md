# Mykonos v6.15.0 Review-Slot Compression and Quiet-Lane Resurfacing Cadence Grouping Workspace Patch

## Package
- `mykonos-cabnet-v6.15.0-review-slot-compression-and-quiet-lane-resurfacing-cadence-grouping-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `review_slot_compression_label`
  - `quiet_lane_resurfacing_cadence_group_label`
  - `review_slot_compression_digest`
  - `quiet_lane_resurfacing_cadence_group_frame`
- added new overview panel:
  - `Review-Slot Compression and Quiet-Lane Resurfacing Cadence Grouping`
- compressed the loyalty continuity list by replacing four separate quiet-lane scan columns with two grouped cues:
  - `Slot Compression`
  - `Resurface Group`
- updated the linked inquiry loyalty snapshot so the duplicated:
  - `Cadence compression`
  - `Resurface priority`
  entries are replaced with:
  - `Review-slot compression`
  - `Resurfacing cadence group`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.29`

## Why this patch matters
The loyalty workspace could already show:
- cadence compression
- resurfacing priority
- resurfacing compression
- quiet-lane review slot

The remaining friction was scan-width. Operators could see all the ingredients, but they still had to mentally regroup them into one usable checkpoint read while moving between the loyalty list, the workspace overview, and the linked inquiry snapshot.

This patch keeps the workspace narrow and operator-owned while reducing that regrouping burden:
- one compressed slot cue
- one grouped resurfacing cadence cue
- a dedicated overview panel
- a cleaner linked inquiry loyalty snapshot
- a more compressed loyalty list
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
