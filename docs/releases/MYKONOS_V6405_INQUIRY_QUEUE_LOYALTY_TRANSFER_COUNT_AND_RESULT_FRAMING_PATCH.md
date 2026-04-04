# Mykonos v6.40.5 Inquiry Queue Loyalty Transfer-Count and Result Framing Patch

## Package
- `mykonos-cabnet-v6.40.5-inquiry-queue-loyalty-transfer-count-and-result-framing-patch.zip`

## What changed
- adds compact queue-overview counts for loyalty posture buckets:
  - Linked to loyalty
  - Transfer-ready
  - Draft-ready
  - Queue-only
  - Workspace staged
- adds a loyalty-routing summary block above the main queue metrics
- keeps the new board conservative and read-only
- does not change schema, theme, or `/plan`

## Why this patch matters
The Inquiry Queue already shows loyalty link state, queue-row backlink posture, direct continuity actions, and a loyalty-posture filter. The remaining friction was that operators still had to infer continuity workload from the list and filter alone.

This patch gives the queue overview a compact loyalty workload frame so operators can see transfer pressure immediately before applying the filter or opening individual rows.

## Install
1. Upload the rooted files into `/home/cabnet/public_html/`
2. From `/home/cabnet/public_html/mykonos.cabnet.app` run:
   - `php artisan cache:clear`
3. Open backend → **Mykonos Inquiries**

## Verify
- the Queue overview now shows a second compact loyalty-routing summary card
- the summary card shows counts for:
  - Linked to loyalty
  - Transfer-ready
  - Draft-ready
  - Queue-only
  - Workspace staged
- the summary text changes conservatively based on the current workload mix

## Notes
- no migration
- no schema change
- no theme change
- no `plugin:refresh` required
