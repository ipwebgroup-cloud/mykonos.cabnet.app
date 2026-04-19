# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.19.00 inquiry record closure-to-reopen decision strip`
- plugin tracking `2.4.27`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact closure-to-reopen decision strip directly to the inquiry record so operators can compare closure evidence against current reopen signals and get one concise decision layer before changing posture.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Closure to Reopen Decision strip appears on the inquiry record
- the strip shows one decision label plus closure evidence, reopen signal strength, and decision cues
- Reopen Readiness Evidence, Closure History Evidence, Closure Readiness, Operator Action Recap, Final Readiness, Operator Priority Recap, Workflow Summary, Operator Summary Recap, and earlier strips remain visible
