# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.22.00 inquiry record action confidence check strip`
- plugin tracking `2.4.30`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact Action Confidence Check strip directly to the inquiry record so operators can quickly see whether the currently recommended next move is strongly supported or still fragile.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Action Confidence Check strip appears on the inquiry record
- the strip shows a confidence label, support guidance, and visible anchor check based on the current posture
- Next Best Action After Decision, Closure Decision Audit, Closure to Reopen Decision, Reopen Readiness Evidence, Closure History Evidence, Closure Readiness, Operator Action Recap, Final Readiness, Operator Priority Recap, Workflow Summary, Operator Summary Recap, and earlier strips remain visible
