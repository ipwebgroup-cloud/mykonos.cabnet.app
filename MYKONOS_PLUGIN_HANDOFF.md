# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.76 loyalty list row wording compression patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It compresses the visible Loyalty Continuity source summary card so operators can scan source, outcome, packet, and review timing faster without losing the same signals.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Loyalty Continuity
- source summary cards read a little tighter
- the same source, outcome, packet, and review signals still appear
- list behavior remains unchanged
