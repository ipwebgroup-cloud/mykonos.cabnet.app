# Mykonos v2.6.28 — History Note Framing Panel

## Package
- `mykonos-v2.6.28-history-note-framing-panel-rooted-patch.zip`

## What changed
- added a read-only **History Note Framing** panel to the backend inquiry **History** tab
- places scan-first guidance between:
  - **History Timeline**
  - **Add Internal Note**
- helps operators write cleaner append-only timeline entries by emphasizing:
  - what changed
  - what the next operator must know
  - what the next checkpoint is
  - what should *not* be duplicated from the full inquiry form
- keeps the patch backend-only with:
  - no schema change
  - no list change
  - no quick-action change
  - no public `/plan` change

## Why this patch matters
The Internal tab now has a strong scan-first operator workspace. The remaining continuity gap was on the **History** tab itself: operators could scan the timeline, but the screen still moved directly into raw note entry without a framing layer for append-only note quality.

This patch closes that gap without altering persistence behavior.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_history_note_framing_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open any existing inquiry
3. Open the **History** tab
4. Confirm **History Note Framing** appears between:
   - **History Timeline**
   - **Add Internal Note**
5. Confirm the panel renders without crashing even when:
   - the inquiry has little history
   - the inquiry has only system notes
   - the inquiry is closed
6. Save a new internal note and confirm timeline behavior remains unchanged

## Notes
- This is a production-safe operator usability patch.
- It continues the v2.6.x consolidation line without touching the public theme/plugin bridge.
