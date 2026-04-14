# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.83 shared badge-tone consistency pass`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It gives similar visible queue and loyalty hint signals more consistent badge/chip treatment so operators can scan linked, transfer-ready, queue-origin, and related states with more uniform visual emphasis.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- similar visible hint states use more consistent chip treatment
- list behavior remains unchanged
