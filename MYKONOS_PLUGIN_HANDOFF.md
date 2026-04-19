# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.23.00 inquiry record evidence gap priority strip`
- plugin tracking `2.4.31`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact Evidence Gap Priority strip directly to the inquiry record so operators can quickly see which single missing continuity anchor would most improve confidence first.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Evidence Gap Priority strip appears on the inquiry record
- the strip shows the top gap, a resolve-first cue, and a secondary gap based on the current posture
- Action Confidence Check, Next Best Action After Decision, Closure Decision Audit, Closure to Reopen Decision, Reopen Readiness Evidence, Closure History Evidence, Closure Readiness, Operator Action Recap, Final Readiness, Operator Priority Recap, Workflow Summary, Operator Summary Recap, and earlier strips remain visible
