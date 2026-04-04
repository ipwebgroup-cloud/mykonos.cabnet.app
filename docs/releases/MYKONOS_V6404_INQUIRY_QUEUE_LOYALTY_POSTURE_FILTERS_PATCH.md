# Mykonos v6.40.4 Inquiry Queue Loyalty Posture Filters Patch

## Package
- `mykonos-cabnet-v6.40.4-inquiry-queue-loyalty-posture-filters-patch.zip`

## Current state assessment
The Loyalty Continuity workspace is now live, schema-ready, and already connected back into the Inquiry Queue through loyalty-link, backlink, cue, and action lanes.

The remaining queue-side friction was filtering: operators could see continuity posture on each inquiry row, but could not isolate linked versus transfer-ready versus draft-ready work without manual row-by-row scanning.

## What changed
- added a dedicated Inquiry Queue filter scope:
  - `Loyalty Posture`
- added filter buckets:
  - `Linked to loyalty`
  - `Transfer-ready`
  - `Draft-ready`
  - `Queue-only`
  - `Workspace staged`
- implemented a conservative custom query scope on the inquiry model so the filter remains schema-safe and does not require a migration
- updated the queue command board copy to direct operators to the new posture filter when they need to isolate continuity-transfer work

## Install
1. Upload the rooted patch into `/home/cabnet/public_html/`
2. Clear cache:
   - `php artisan cache:clear`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open the filters row
3. Confirm **Loyalty Posture** appears
4. Verify the queue can isolate:
   - linked inquiries
   - transfer-ready inquiries
   - draft-ready inquiries
   - queue-only inquiries

## Notes
- no schema change
- no theme change
- no `/plan` change
- plugin-only and production-safe
