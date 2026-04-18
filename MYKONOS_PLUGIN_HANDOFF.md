# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v7.04.00 inquiry record guest-profile strip`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`, SMTP, schema, or queue logic.
It adds a compact guest-profile strip directly to the inquiry record so operators can compare contact-quality posture and guest-profile posture from one backend screen.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- open Backend -> Inquiries -> any real inquiry record
- a new Guest Profile strip appears on the inquiry record
- the strip shows a primary profile posture and profile signals
- Contact Quality, Reply Channel, Proposal Delivery, Proposal Readiness, Partner Routing, Concierge Handoff, Internal Urgency, Internal Escalation, Follow-Up Readiness Recap, Follow-Up Ownership, Follow-Up Timing, Internal Next Action, Reply Draft Framing, Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain unchanged and visible

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves guest-profile judgment directly inside the inquiry record
- keeps profile guidance visible without changing workflow state
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays backend-only and render-safe

## Safest next step

After this backend guest-profile pass, the next strong step should be one of:
- add stronger hospitality tone refinement to the guest confirmation template
- add a compact internal stay-profile strip to the inquiry record
- add a lightweight backend resend action only after record-side context surfaces are fully stabilized
