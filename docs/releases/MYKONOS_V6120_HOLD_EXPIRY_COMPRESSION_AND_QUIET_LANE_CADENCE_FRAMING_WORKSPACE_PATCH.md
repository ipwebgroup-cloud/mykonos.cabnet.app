# Mykonos Loyalty Workspace v6.12.0 Hold-Expiry Compression and Quiet-Lane Cadence Framing Workspace Patch

## Package
- `mykonos-cabnet-v6.12.0-hold-expiry-compression-and-quiet-lane-cadence-framing-workspace-patch.zip`

## What changed
- added read-only loyalty cues:
  - `hold_expiry_compression_label`
  - `quiet_lane_cadence_label`
- added supporting read-only summaries:
  - `hold_expiry_compression_digest`
  - `quiet_lane_cadence_frame`
- added a new Overview workspace panel:
  - `Hold-Expiry Compression and Quiet-Lane Cadence`
- surfaced the same new cues in:
  - the loyalty record list
  - the linked inquiry loyalty continuity snapshot
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.26`

## Why this patch matters
The loyalty line could already show hold-expiry grouping and quiet-lane re-entry ordering.

The remaining friction was compression and cadence readability: operators could see where a quiet hold belonged, but still had to mentally rebuild whether the hold was collapsing into action now or how often it should surface in human review.

This patch keeps that narrower and easier to scan without introducing automation, schema drift, or theme changes.

## Install
1. Upload the rooted patch contents into `/home/cabnet/public_html/` so files land under `mykonos.cabnet.app/...`
2. Clear cache only if backend output appears stale:
   - `php artisan cache:clear`

## Notes
- plugin-only patch
- no schema change
- no migration change
- no theme change
- do **not** run `php artisan plugin:refresh Cabnet.MykonosInquiry` for this patch
