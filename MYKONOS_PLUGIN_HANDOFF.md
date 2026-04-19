# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.31.00 inquiry record safest queue action timing strip`
- plugin tracking `2.4.38`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact Safest Queue Action Timing strip directly to the inquiry record so operators can judge when the recommended queue move is timely versus premature.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Safest Queue Action Timing strip appears on the inquiry record after Queue Move Risk Summary
- the strip shows a timing verdict, timing window, watch-before-moving guidance, next timing checkpoint, and timing anchor readiness
- earlier closure/reopen guidance strips remain visible
