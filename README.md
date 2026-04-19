# Mykonos Cabnet Inquiry Patch Line

Latest rooted patch prepared in this workspace:
- `v7.23.00 inquiry record evidence gap priority strip`

This patch is backend-only and render-safe.
It adds a compact Evidence Gap Priority strip to the inquiry record so operators can quickly see which single missing continuity anchor would most improve confidence first.

Operational posture:
- no schema change
- no plugin refresh required
- no theme import required
- no `/plan` behavior change
- no queue logic change
- no SMTP change

Deployment:
- upload rooted files preserving `mykonos.cabnet.app/...`
- run `php artisan cache:clear`
