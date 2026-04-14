# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.79 shared List Setup ordering polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It groups visible daily scan columns first and denser optional diagnostics after them in both list column files so List Setup feels more logical without changing the default daily view.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> List Setup
- Backend -> Loyalty Continuity -> List Setup
- related optional columns sit nearer each other
- default visible list views remain unchanged
