# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.89 shared cell-edge rounding and border polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It lightly polishes corners, border softness, and card edges on the visible queue action cell and loyalty source-summary card so they feel more visually unified without changing layout or behavior.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- visible list cells feel a little more unified at the edges
- list behavior remains unchanged
