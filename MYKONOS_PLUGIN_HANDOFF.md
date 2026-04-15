# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.57.00 stale timing posture cues across inquiry and loyalty records`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list pages from simple helper notes into larger operator quick-start surfaces that explain the daily scan workflow, queue-to-loyalty bridge posture, and when to widen the view with List Setup or deeper docs.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open an inquiry with a linked loyalty record
- Backend -> Loyalty Continuity -> open a loyalty record with a source inquiry
- both record screens now show a stale-timing posture strip above the main summary shell when both sides of the bridge exist
- tabs, actions, and form behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- makes queue-versus-continuity timing drift visible immediately
- helps operators decide which lane owns the next live checkpoint
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this timing-visibility pass, the next strong step should be one of:
- add compact stale-timing cues on the linked list screens when both sides are overdue
- add a small ownership-and-timing digest inside Workspace Docs for bridge training
- add conservative closure-versus-continuity readiness cues when an inquiry is closed but loyalty timing remains open
