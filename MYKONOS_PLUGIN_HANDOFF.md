# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.20.00 inquiry record closure-decision audit strip`
- plugin tracking `2.4.28`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact closure-decision audit strip directly to the inquiry record so operators can see, in plain language, why the current posture reads as active, remain closed, document before reopen, or reopen deliberately.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Closure Decision Audit strip appears on the inquiry record
- the strip explains the current posture using visible closure evidence, reopen signals, and operator guidance
- Closure to Reopen Decision, Reopen Readiness Evidence, Closure History Evidence, Closure Readiness, Operator Action Recap, Final Readiness, Operator Priority Recap, Workflow Summary, Operator Summary Recap, and earlier strips remain visible
