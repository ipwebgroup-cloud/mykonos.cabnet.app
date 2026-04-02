# Mykonos v2.6.3 Contact Posture Panel

## Package
- `mykonos-cabnet-v2.6.3-contact-posture-panel-changed-files.zip`

## What changed
- added a new read-only **Contact Posture** panel on the **Internal** tab
- surfaces:
  - preferred contact route
  - live contact posture
  - continuity check
- gives operators one scan-first surface for:
  - whether a usable guest route exists
  - whether outreach is already logged
  - whether the next communication move is explicit

## Why this patch matters
The `v2.6` line is consolidating the inquiry update screen into a cleaner operator workspace. This patch improves the communication side of that workspace without introducing new workflow logic or schema changes.

## Scope
- backend detail screen only
- no schema change
- no public theme change
- no list filter change
