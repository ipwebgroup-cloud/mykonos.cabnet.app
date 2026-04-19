# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.26.00 inquiry record why pause first strip`
- plugin tracking `2.4.34`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact Minimum Evidence to Proceed strip directly to the inquiry record so operators can quickly see whether the smallest acceptable anchor set for the current posture is already visible before they act.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Evidence Gap Priority strip appears on the inquiry record
- the strip shows the threshold count, missing essentials, and anchor set based on the current posture
- Minimum Evidence to Proceed, Evidence Gap Priority, Action Confidence Check, Next Best Action After Decision, Closure Decision Audit, Closure to Reopen Decision, Reopen Readiness Evidence, Closure History Evidence, Closure Readiness, Operator Action Recap, Final Readiness, Operator Priority Recap, Workflow Summary, Operator Summary Recap, and earlier strips remain visible


- Latest patch line: v7.25.00 inquiry record proceed-or-pause recommendation strip
- New record strip added after Minimum Evidence to Proceed: Proceed or Pause Recommendation


- Latest patch line: v7.26.00 inquiry record why pause first strip
- New record strip added after Proceed or Pause Recommendation: Why Pause First
