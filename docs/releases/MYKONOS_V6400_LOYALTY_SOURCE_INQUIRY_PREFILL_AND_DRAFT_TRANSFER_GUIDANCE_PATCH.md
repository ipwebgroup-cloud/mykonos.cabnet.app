# Mykonos v6.40.0 Loyalty Source Inquiry Prefill and Draft Transfer Guidance Patch

## Package
- `mykonos-cabnet-v6.40.0-loyalty-source-inquiry-prefill-and-draft-transfer-guidance-patch.zip`

## What changed
- loyalty create form now supports `?source_inquiry_id=ID` prefill
- create mode seeds request reference, guest basics, source summary, and continuity summary from the linked inquiry before first save
- inquiry detail loyalty actions now expose a second path:
  - direct create + open real loyalty record
  - open a prefilled loyalty draft for manual review before first save
- added create-form guidance so operators know when to use manual draft creation versus inquiry-backed continuity transfer

## Why this patch matters
The loyalty workspace is now live and the create form no longer crashes, but a blank manual draft still leaves operators retyping context that already exists on the inquiry. This patch keeps the workflow plugin-only and production-safe while anchoring first-save loyalty drafts to the real inquiry context when available.

## Install
1. Upload the rooted files into `mykonos.cabnet.app/...`
2. Run `php artisan cache:clear`
3. Verify:
   - open an inquiry detail screen
   - use **Open prefilled loyalty draft**
   - confirm the create form opens with request reference, guest basics, and summaries already seeded

## Notes
- no schema change
- no migration required
- no `/plan` change
- this patch continues from the `v6.39.4` create-form render-safe line
