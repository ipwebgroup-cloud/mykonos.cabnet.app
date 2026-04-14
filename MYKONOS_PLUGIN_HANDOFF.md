# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.88 shared card-width consistency pass`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It brings the Inquiry Queue action cell and the Loyalty Continuity source-summary card a little closer in horizontal balance by nudging their min/max widths without changing content or behavior.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- the queue action cell and loyalty source-summary card feel a bit more balanced horizontally
- list behavior remains unchanged
