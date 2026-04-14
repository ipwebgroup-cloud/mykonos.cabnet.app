# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.43.00 route-state summary strips for queue and loyalty`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It adds one compact route-state summary strip above both list pages so operators can immediately see current view posture, active filter/search context, and queue-to-loyalty routing state before widening the list or opening records.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages now show a compact route-state strip above the list area
- search, filters, and row actions still behave as before
- `/plan` remains untouched

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves list-to-record orientation without changing queue logic
- makes current filter/search posture easier to confirm at a glance
- surfaces queue-to-loyalty routing state in a safer compact layer
- keeps the live `/plan` bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this route-state pass, the next strong step should be one of:
- upgrade the Workspace Docs page into a fuller operator playbook dashboard
- add one compact record-opening orientation strip inside both update forms
- refine queue and loyalty list empty/default states with the same operator language system
