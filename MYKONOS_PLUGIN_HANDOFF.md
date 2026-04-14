# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.86 shared primary button consistency pass`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It aligns the visible primary row-action buttons across Inquiry Queue and Loyalty Continuity so the main actions share a more consistent blue emphasis and spacing treatment.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- primary visible row-action buttons share more consistent emphasis
- list behavior remains unchanged
