# Mykonos Loyalty Workspace v6.9.0 Hold-Aging Readability and Quiet-Return Review Timing Patch

## Package
- `mykonos-cabnet-v6.9.0-hold-aging-readability-and-quiet-return-review-timing-workspace-patch.zip`

## What changed
- added conservative read-only loyalty cues for:
  - `hold_aging_label`
  - `quiet_return_review_timing_label`
- added read-only digest/frame outputs for:
  - `hold_aging_digest`
  - `quiet_return_review_timing_frame`
- added a new Overview panel:
  - `Hold Aging and Quiet-Return Review Timing`
- surfaced the new cues on:
  - the loyalty record Overview workspace
  - the linked inquiry loyalty continuity snapshot
  - the loyalty list columns
- updated continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch matters
The current loyalty line could already show post-close hold posture, hold release, quiet-lane return, and finish-lane handback.

The remaining friction was temporal readability: operators could tell that a record was sitting in a quiet close posture, but still had to infer whether that hold was still fresh, maturing toward review, stable for later review, or already aged out into active human timing.

This patch keeps the workspace narrow and operator-owned while making quiet-hold timing easier to read at both record level and list-scan level.

## Install
1. Upload the patch contents into `/home/cabnet/public_html/`
2. Confirm the files land under `mykonos.cabnet.app/...`
3. Clear cache only if backend partial output appears stale

## Notes
- No theme change
- No schema change
- No `php artisan plugin:refresh Cabnet.MykonosInquiry` required
