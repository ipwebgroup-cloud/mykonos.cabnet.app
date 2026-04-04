# Mykonos v6.23.0 Owner-Held Quiet-Lane Acceptance Compression and Tagged Return Checkpoint Framing Workspace Patch

## Package
- `mykonos-cabnet-v6.23.0-owner-held-quiet-lane-acceptance-compression-and-tagged-return-checkpoint-framing-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `owner_held_quiet_lane_acceptance_compression_label`
  - `tagged_return_checkpoint_framing_label`
  - `owner_held_quiet_lane_acceptance_compression_digest`
  - `tagged_return_checkpoint_framing_frame`
- added new overview panel:
  - `Owner-Held Quiet-Lane Acceptance Compression and Tagged Return Checkpoint Framing`
- compressed the loyalty continuity list again by replacing the prior tagged-return/quiet-accept pair with two narrower operator cues:
  - `Held Acceptance`
  - `Tagged Checkpoint`
- updated the linked inquiry loyalty snapshot so the prior tagged-return/quiet-accept cues are now shown as:
  - `Held acceptance`
  - `Tagged checkpoint`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.37`

## Why this patch matters
The loyalty workspace could already keep the quiet-lane return owner-tagged and the same-day quiet acceptance explicit.

The remaining friction was that operators still had to translate those two cues one extra step across the list, overview, and linked inquiry snapshot. The safer next reduction was to compress that end-of-chain read into one owner-held quiet acceptance and one tagged return checkpoint frame.

This patch keeps the workspace narrow and operator-owned while compressing that translation step again:
- one owner-held quiet-lane acceptance compression cue
- one tagged return checkpoint framing cue
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
