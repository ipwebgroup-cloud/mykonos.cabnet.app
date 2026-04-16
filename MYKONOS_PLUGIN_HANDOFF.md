# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.69.00 lane priority chips above queue and loyalty lists`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list pages with compact lane-priority snapshot strips that show which lane deserves attention first using real current counts.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages now show a lane-priority snapshot strip above the list
- queue and loyalty actions, filters, and list behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves first-pass scan speed
- keeps queue-to-continuity posture visible before opening records
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this list-level scan-speed pass, the next strong step should be one of:
- add compact companion counters for overdue review versus unscheduled review above both lists
- add a compact bridge attention score strip above both lists using real posture counts
- improve row-level linked record quick-open orientation without widening the list actions
