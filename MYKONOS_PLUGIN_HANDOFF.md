# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.93 shared title-line truncation polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It makes the first-line reference/posture text and a few compact inline chip values inside the loyalty source-summary card clip more gracefully when strings run long.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Loyalty Continuity
- long source references and similar first-line strings clip more gracefully
- list behavior remains unchanged
