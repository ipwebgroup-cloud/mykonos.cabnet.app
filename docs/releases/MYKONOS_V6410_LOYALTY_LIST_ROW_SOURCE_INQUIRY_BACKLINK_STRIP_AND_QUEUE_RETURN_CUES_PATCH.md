# Mykonos v6.41.0 Loyalty List-Row Source Inquiry Backlink Strip and Queue-Return Cues Patch

## Package
- `mykonos-cabnet-v6.41.0-loyalty-list-row-source-inquiry-backlink-strip-and-queue-return-cues-patch.zip`

## What changed
- added a compact **Source Inquiry** strip directly on each Loyalty Continuity list row
- linked loyalty records now show:
  - originating inquiry reference / guest anchor
  - original inquiry status / priority posture
  - owner and queue/follow-up hint
  - direct `Open inquiry` action
  - direct `Back to queue search` action
- manual loyalty records remain render-safe and show a conservative fallback state without broken links

## Why this patch matters
The queue-to-loyalty bridge is now live, but the loyalty list itself still forced operators to open the record before jumping back to the inquiry that created it.

This patch makes the backlink visible directly on the loyalty row so operators can confirm source context and return to the queue faster without widening the workflow.

## Install
1. Upload the rooted files into `/home/cabnet/public_html/`
2. Clear cache:
   `php artisan cache:clear`

## Notes
- No migration
- No schema change
- No theme change
- Plugin-only and render-safe
