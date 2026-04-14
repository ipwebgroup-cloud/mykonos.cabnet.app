# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.77 shared list-setup guidance polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It aligns the helper guidance on Inquiry Queue and Loyalty Continuity so both list pages explain the same scan-first default rule and point operators toward List Setup for denser diagnostics.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages show matching scan-first guidance
- list behavior remains unchanged
