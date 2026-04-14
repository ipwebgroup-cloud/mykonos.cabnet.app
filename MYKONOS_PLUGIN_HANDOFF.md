# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.90 shared chip-size normalization pass`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It normalizes the visible hint-chip and packet-chip sizing across Inquiry Queue and Loyalty Continuity so similar compact signals sit closer in visual scale.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- hint chips and packet chips feel closer in size across both list pages
- list behavior remains unchanged
