# Mykonos v4.9.0 Loyalty Activation Schema and Transfer Wiring Patch

## Package
- plugin-only rooted patch

## What changed
- added guarded schema-readiness checks so Loyalty Continuity only becomes editable when both:
  - the loyalty record table exists **and**
  - the touchpoint ledger exists **and**
  - both tables contain the columns required by the current live workspace model
- added non-destructive upgrade migrations to align the staged loyalty tables with the actual live loyalty model
- upgraded the inquiry-side loyalty panel so **Create + open loyalty record** now performs a real plugin-side transfer and opens the resulting loyalty record directly
- added read-only loyalty record panels for:
  - transfer audit
  - record detail structure
- hardened touchpoint persistence so appended loyalty notes populate both the narrative fields and the structured touchpoint fields

## Why this patch exists
The loyalty workspace had reached the point where the UI expected a richer record structure than the early staged activation migrations actually produced. That meant the workspace could look installable while still not being safe for deliberate activation.

This patch closes that gap without disturbing the live Inquiry Queue.

## Install
1. Upload the changed plugin files into `plugins/cabnet/mykonosinquiry`
2. Upload the updated root handoff file into `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
3. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
4. Open backend → **Loyalty Continuity**
5. Verify:
   - install overview reports schema alignment clearly
   - once upgraded, the loyalty list and record update screens render the real form
   - from an eligible inquiry, **Create + open loyalty record** opens the linked loyalty record directly

## Notes
- no theme change
- no destructive migration
- Inquiry Queue remains the live operational workspace
- loyalty activation remains intentionally guarded until the schema is fully aligned
