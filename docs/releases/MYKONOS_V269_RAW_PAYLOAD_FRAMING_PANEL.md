# Mykonos v2.6.29 — Raw Payload Framing Panel

## Package
- `mykonos-v2.6.29-raw-payload-framing-panel-rooted-patch.zip`

## What changed
- added a read-only **Raw Payload Framing** panel to the backend inquiry **Raw** tab
- places scan-first guidance above:
  - **Raw Payload**
- helps operators use the saved payload as:
  - a continuity fallback
  - a source and entry checkpoint
  - a reopen/reference layer when summaries or notes are thin
- keeps the patch backend-only with:
  - no schema change
  - no list change
  - no quick-action change
  - no public `/plan` change

## Why this patch matters
The current v2.6.x line now gives operators strong scan-first surfaces on the **Internal** and **History** tabs. The remaining rough edge was the **Raw** tab: it exposed pretty JSON, but still lacked a framing layer that helps the operator understand when the payload is useful, what continuity signals it contains, and when the normalized record may need a summary refresh.

This patch closes that gap without changing storage or workflow behavior.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_raw_payload_framing_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open any existing inquiry
3. Open the **Raw** tab
4. Confirm **Raw Payload Framing** appears above **Raw Payload**
5. Confirm the panel renders without crashing when:
   - the payload is empty
   - the payload is stored as a JSON string
   - the payload is stored as an array/object
6. Confirm the existing **Raw Payload** textarea still renders unchanged

## Notes
- This is a production-safe operator usability patch.
- It continues the v2.6.x consolidation line without touching the public theme/plugin bridge.
