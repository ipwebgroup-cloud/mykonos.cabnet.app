# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.91.00 inquiry record reply-draft framing strip`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact reply-draft framing strip directly to the inquiry record so operators can turn saved inquiry context into a cleaner first-response structure from the same backend screen.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Reply Draft Framing strip appears on the inquiry record
- the strip shows opening, availability angle, clarifying bridge, and closing direction blocks
- Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain unchanged and visible

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves first-response drafting directly inside the inquiry record
- keeps reply structure visible without changing workflow state
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays backend-only and render-safe

## Safest next step

After this backend draft-framing pass, the next strong step should be one of:
- add stronger hospitality tone refinement to the guest confirmation template
- add a compact internal next-action strip to the inquiry record
- add a lightweight backend resend action only after record-side context surfaces are fully stabilized
