# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.91 shared muted-text tone polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It aligns the lighter helper/posture text tone in the visible loyalty summary card to a slightly cleaner muted shade so the quieter text reads more consistently with the compact queue-and-loyalty UI line.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Loyalty Continuity
- lighter helper/posture text reads a bit cleaner and more consistent
- list behavior remains unchanged
