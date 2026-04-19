# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.21.00 inquiry record next best action after decision strip`
- plugin tracking `2.4.29`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact Next Best Action After Decision strip directly to the inquiry record so operators can see the single safest immediate move after the current closure-versus-reopen posture is already visible.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Next Best Action After Decision strip appears on the inquiry record
- the strip shows a do-now move, avoid-now caution, and operator cue based on the current posture
- Closure Decision Audit, Closure to Reopen Decision, Reopen Readiness Evidence, Closure History Evidence, Closure Readiness, Operator Action Recap, Final Readiness, Operator Priority Recap, Workflow Summary, Operator Summary Recap, and earlier strips remain visible
