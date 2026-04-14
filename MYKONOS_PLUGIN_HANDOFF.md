# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.78 shared list-setup naming polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It makes the heavier optional columns read more clearly inside List Setup while keeping the lighter default daily scan view unchanged.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> List Setup
- Backend -> Loyalty Continuity -> List Setup
- heavier optional column names read more clearly
- default list behavior remains unchanged
