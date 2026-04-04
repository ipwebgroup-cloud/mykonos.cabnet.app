# Mykonos v6.40.8 Loyalty Continuity Empty-State Guidance Patch

## Package
- `mykonos-cabnet-v6.40.8-loyalty-continuity-empty-state-guidance-patch.zip`

## Current state
Loyalty Continuity is now schema-ready, list-rendering, and create-form safe, but a brand-new installation can still look confusing because the live list is empty even though the workspace is already fixed.

## What changed
- added a live loyalty empty-state guidance panel on the Loyalty Continuity list page
- the panel appears only when:
  - loyalty storage is ready
  - the loyalty list has zero saved records
- the panel explains that an empty list is normal
- the panel points operators back to **Inquiry Queue** as the preferred source for the first real loyalty records
- the panel summarizes:
  - transfer-ready inquiries
  - draft-ready inquiries
  - queue-only inquiries
- the panel still keeps manual loyalty creation available for non-inquiry-origin continuity records

## Install
1. Upload the rooted patch files into `/home/cabnet/public_html/`
2. Clear cache:
   `php artisan cache:clear`
3. Open backend → **Mykonos Inquiries** → **Loyalty Continuity**

## Verify
- when the loyalty list has zero records, a new guidance panel appears above the list
- the panel links operators back to **Inquiry Queue**
- the panel explains whether the first record should come from a transfer-ready inquiry, a prefilled draft, or remain queue-only for now
- once the first loyalty record is saved, the empty-state guidance panel disappears automatically

## Notes
- no schema change
- no migration
- no `/plan` change
- plugin-only and render-safe
