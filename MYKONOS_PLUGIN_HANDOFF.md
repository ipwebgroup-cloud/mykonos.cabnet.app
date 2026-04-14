# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.82 shared list microcopy polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It shortens tiny visible list hints and badge-adjacent microcopy on Inquiry Queue and Loyalty Continuity so operators get the same signals with slightly less noise.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- tiny visible hint text reads a bit cleaner
- list behavior remains unchanged
