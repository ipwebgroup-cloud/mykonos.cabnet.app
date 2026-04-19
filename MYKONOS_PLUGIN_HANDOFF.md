# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.30.00 inquiry record queue move risk summary strip`
- plugin tracking `2.4.37`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact Recommended Queue Action Summary strip directly to the inquiry record so operators can convert the full readiness recap into the safest queue-handling move.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Recommended Queue Action Summary strip appears on the inquiry record after Proceed Readiness Summary
- the strip shows queue action, why this queue move, avoid-now guidance, and required anchors
- earlier closure/reopen guidance strips remain visible

- Queue Move Risk Summary
