# Mykonos Loyalty Workspace v6.1.0

## Patch
- `mykonos-cabnet-v6.1.0-stewardship-snapshot-compression-and-list-level-finish-triage-workspace-patch.zip`

## Type
- plugin-only major patch
- no theme change
- no schema change

## What changed
- added a new **Finish Triage Dashboard** panel on live loyalty records
- added compressed finish and stewardship readouts:
  - `finish_triage_label`
  - `finish_triage_urgency_label`
  - `stewardship_snapshot_compressed`
  - `finish_triage_digest`
- loyalty list now surfaces:
  - `Finish Triage`
  - `Triage Urgency`
- linked inquiry loyalty snapshot now shows:
  - finish triage
  - triage urgency
  - compressed stewardship snapshot
  - finish triage digest

## Why this patch exists
The loyalty line could already show a readable finish dashboard and parked-lane closure posture, but operators still had to read too much of the full detail to decide which records deserved attention first.

This patch compresses that decision into a narrower, faster triage surface so finish-lane handling becomes easier to scan from:
- the loyalty list
- the loyalty record overview
- the linked inquiry continuity snapshot

## Install
1. Upload the changed files into `mykonos.cabnet.app/...`
2. No `plugin:refresh` is required
3. Clear backend cache if the new panel or list columns do not appear immediately

## Notes
- This patch stays plugin-only.
- This patch does not widen into automation or campaign logic.
- This patch keeps the finish lane human-owned and deliberately narrow.
