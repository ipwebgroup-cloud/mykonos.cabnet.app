# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.81 shared row-action label polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It shortens the visible row-action labels on Inquiry Queue and Loyalty Continuity so the buttons read faster while keeping the same actions and routes.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- row action buttons read shorter and more consistently
- action behavior remains unchanged
