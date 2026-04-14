# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.47.00 inquiry status transition caution cues`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It adds a compact caution layer to the inquiry record screen so closure, reopen, and major status changes carry clearer operator discipline before save.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open any inquiry
- the inquiry record now shows a compact transition caution strip above the main summary shell
- closure and reopen cues render in plain language using live record values
- save flow, notes, tabs, and quick actions remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves discipline around the highest-impact status changes
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this transition-cues pass, the next strong step should be one of:
- mirror the same caution discipline on the loyalty record for finish, hold, and reopen posture changes
- enrich Workspace Docs with a dedicated transition and closure playbook section
- add small record-header route reminders without widening the form UI further
