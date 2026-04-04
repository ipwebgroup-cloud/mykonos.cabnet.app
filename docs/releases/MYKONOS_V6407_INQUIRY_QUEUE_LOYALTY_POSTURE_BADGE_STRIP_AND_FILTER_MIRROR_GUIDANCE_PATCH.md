# Mykonos v6.40.7 Inquiry Queue Loyalty Posture Badge Strip and Filter-Mirror Guidance Patch

## Package
- `mykonos-cabnet-v6.40.7-inquiry-queue-loyalty-posture-badge-strip-and-filter-mirror-guidance-patch.zip`

## What changed
- adds a compact loyalty-posture badge strip to the Inquiry Queue overview
- mirrors the same bucket names used by the `Loyalty Posture` filter:
  - Linked to loyalty
  - Transfer-ready
  - Draft-ready
  - Queue-only
  - Workspace staged
- adds short operator hints for each bucket so the filter intent is visible before opening the popup
- keeps the existing queue filter logic, row actions, backlink summaries, and transfer-count cards unchanged

## Why this patch matters
The queue already exposed continuity counts and a dedicated `Loyalty Posture` filter, but operators still had to remember what each bucket meant when switching between the overview cards and the popup. This patch keeps the workflow narrow and render-safe by adding a badge strip that mirrors the live filter buckets directly in the queue overview.

## Install
1. Upload the rooted files into `/home/cabnet/public_html/`
2. Run `php artisan cache:clear` from `/home/cabnet/public_html/mykonos.cabnet.app`
3. Open backend → **Mykonos Inquiries**
4. Verify the Queue overview shows the new badge strip and that the `Loyalty Posture` filter still opens and applies normally

## Notes
- no migration
- no schema change
- no theme change
- plugin-only and production-safe
