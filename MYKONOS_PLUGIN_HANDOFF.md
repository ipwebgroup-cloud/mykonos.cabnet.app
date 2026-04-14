# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.84 shared list-cell spacing polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It evens out the compact vertical rhythm in the visible Inquiry Queue and Loyalty Continuity list cells so chips, buttons, and card sections sit a little more consistently without changing the same signals.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- compact chips, buttons, and summary sections sit more evenly
- list behavior remains unchanged
