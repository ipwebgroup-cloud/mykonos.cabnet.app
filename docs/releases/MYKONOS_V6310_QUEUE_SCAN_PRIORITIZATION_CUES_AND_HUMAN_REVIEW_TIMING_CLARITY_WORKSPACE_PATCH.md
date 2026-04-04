# Mykonos v6.31.0 Queue-Scan Prioritization Cues and Human Review Timing Clarity Workspace Patch

## Package
- `mykonos-cabnet-v6.31.0-queue-scan-prioritization-cues-and-human-review-timing-clarity-workspace-patch.zip`

## What changed
- added conservative loyalty readouts for:
  - `queue_scan_prioritization_cue_label`
  - `human_review_timing_clarity_label`
  - `queue_scan_prioritization_cue_digest`
  - `human_review_timing_clarity_frame`
- added new overview panel:
  - `Queue-Scan Prioritization Cues and Human Review Timing Clarity`
- compressed the loyalty continuity list again by replacing the prior handoff-compress/checkpoint-frame pair with two narrower operator cues:
  - `Queue Priority`
  - `Review Timing`
- updated the linked inquiry loyalty snapshot so the prior handoff/checkpoint pair is now shown as:
  - `Queue priority`
  - `Review timing`
- updated root continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`
- updated plugin version tracking to `2.3.45`

## Why this patch matters
The loyalty workspace could already compress the owner-visible acceptance handoff and the quiet-lane return checkpoint into a narrow end-of-chain read.

The remaining friction was list scanning: operators still had to mentally translate those two cues into queue priority and real human review timing before deciding what should rise now versus what could stay quiet.

This patch keeps the workspace narrow and operator-owned while compressing that translation step again:
- one queue-scan prioritization cue
- one human review timing cue
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
