# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.80 shared List Setup help polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It sharpens the shared helper note on both list pages so operators get one short explanation of which visible columns are best for daily scan work and which deeper columns belong in List Setup.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both helper notes explain the daily-scan-versus-deeper-review rule clearly
- list behavior remains unchanged
