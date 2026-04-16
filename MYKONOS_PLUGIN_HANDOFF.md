# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.70.00 overdue-versus-unscheduled counters above queue and loyalty lists`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It adds compact timing counters above both list pages so operators can see whether overdue work or unscheduled work is currently the bigger drift risk.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages show a compact Overdue vs Unscheduled Snapshot above the list
- queue and loyalty actions, filters, and list behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves first-glance timing awareness
- helps operators separate overdue work from unscheduled backlog
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this timing snapshot pass, the next strong step should be one of:
- add compact bridge-state route pills above both lists using real current filters when present
- add conservative row-level timing color cues only where the current list remains readable
- expand Workspace Docs into a timing discipline playbook that explains the new counters in operator language
