# Mykonos Loyalty Workspace v6.13.0 Cadence Compression and Quiet-Lane Resurfacing Priority Patch

## Package
- `mykonos-cabnet-v6.13.0-cadence-compression-and-quiet-lane-resurfacing-priority-workspace-patch.zip`

## What changed
- added new conservative quiet-lane cues:
  - `cadence_compression_label`
  - `quiet_lane_resurfacing_priority_label`
- added new read-only workspace summaries:
  - `cadence_compression_digest`
  - `quiet_lane_resurfacing_priority_frame`
- added a new Overview panel:
  - `Cadence Compression and Quiet-Lane Resurfacing Priority`
- mirrored the same cues into the linked inquiry loyalty continuity snapshot
- exposed list-level readable columns for:
  - `Cadence Compression`
  - `Resurface Priority`
- updated the root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch exists
The loyalty line could already show hold-expiry compression and quiet-lane cadence, but operators still had to mentally rebuild which quiet lane should surface first once several conservative holds were sitting in the same queue.

This patch keeps the workspace narrow and human-owned by:
- compressing the cadence into one stronger scan cue
- making quiet-lane resurfacing priority explicit
- keeping the result visible on the loyalty record, the loyalty list, and the linked inquiry snapshot
- avoiding automation, theme drift, and schema changes

## Install
1. Upload the rooted patch contents into `/home/cabnet/public_html/`
2. Confirm files land under `mykonos.cabnet.app/...`
3. Clear cache only if backend output appears stale

## Notes
- No schema change
- No migration change
- No theme change
- No `php artisan plugin:refresh Cabnet.MykonosInquiry` required
