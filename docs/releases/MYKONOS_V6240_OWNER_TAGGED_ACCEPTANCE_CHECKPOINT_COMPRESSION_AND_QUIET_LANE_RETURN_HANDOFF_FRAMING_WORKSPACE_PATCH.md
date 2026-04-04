# Mykonos v6.24.0 Owner-Tagged Acceptance Checkpoint Compression and Quiet-Lane Return Handoff Framing Workspace Patch

## Package
- `mykonos-cabnet-v6.24.0-owner-tagged-acceptance-checkpoint-compression-and-quiet-lane-return-handoff-framing-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `owner_tagged_acceptance_checkpoint_compression_label`
  - `quiet_lane_return_handoff_framing_label`
  - `owner_tagged_acceptance_checkpoint_compression_digest`
  - `quiet_lane_return_handoff_framing_frame`
- added new overview panel:
  - `Owner-Tagged Acceptance Checkpoint Compression and Quiet-Lane Return Handoff Framing`
- compressed the loyalty continuity list again by replacing the prior held-acceptance/tagged-checkpoint pair with two narrower operator cues:
  - `Acceptance Checkpoint`
  - `Return Handoff`
- updated the linked inquiry loyalty snapshot so the prior held-acceptance/tagged-checkpoint cues are now shown as:
  - `Acceptance checkpoint`
  - `Return handoff`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.38`

## Why this patch matters
The loyalty workspace could already keep the quiet-lane acceptance owner-held and the tagged checkpoint explicit.

The remaining friction was that operators still had to translate those two cues one extra step across the list, overview, and linked inquiry snapshot. The safer next reduction was to compress that end-of-chain read into one owner-tagged acceptance checkpoint and one quiet-lane return handoff frame.

This patch keeps the workspace narrow and operator-owned while compressing that translation step again:
- one owner-tagged acceptance checkpoint compression cue
- one quiet-lane return handoff framing cue
- a dedicated overview panel
- a cleaner linked inquiry loyalty snapshot
- a tighter human-first loyalty queue read
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
