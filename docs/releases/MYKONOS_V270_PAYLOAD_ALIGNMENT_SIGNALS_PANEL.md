# Mykonos v2.6.30 — Payload Alignment Signals Panel

## Package
- `mykonos-v2.6.30-payload-alignment-signals-panel-rooted-patch.zip`

## Why this patch exists
The stabilized inquiry form now gives operators scan-first guidance on the Internal, History, and Raw tabs. After v2.6.29 added Raw Payload Framing, the remaining gap on the Raw tab was still practical: operators could read the payload more safely, but they still had to manually compare raw JSON against normalized inquiry fields to spot drift.

This patch adds a read-only comparison panel so reopen review and hand-off continuity can detect where the saved payload and current working record are aligned, mismatched, or still too thin.

## What changed
- added a new read-only **Payload Alignment Signals** panel on the **Raw** tab
- compares normalized fields against the saved payload for:
  - request reference
  - source type
  - requested mode
  - guest basics
  - guest country
  - party size
  - arrival / departure
  - services summary
  - guest brief
- surfaces:
  - aligned fields
  - mismatches
  - payload-only context
  - record-only context
  - whether continuity has been promoted into working summary / notes

## Scope
- backend-only
- no schema change
- no backend list change
- no quick-action change
- no public `/plan` change

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_payload_alignment_signals_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Verification
1. Open backend → **Mykonos Inquiries**
2. Open an existing inquiry
3. Open the **Raw** tab
4. Confirm **Payload Alignment Signals** appears above **Raw Payload**
5. Confirm the panel shows aligned / mismatch / payload-only / record-only comparisons without breaking form rendering
6. Confirm the page still saves normally and no public flow changed
