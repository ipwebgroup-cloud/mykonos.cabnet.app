# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.87 shared compact button sizing pass`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It makes the visible row-action buttons across Inquiry Queue and Loyalty Continuity a bit more compact and uniform without changing their routes, labels, or emphasis hierarchy.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- visible row-action buttons feel slightly more compact and uniform
- list behavior remains unchanged
