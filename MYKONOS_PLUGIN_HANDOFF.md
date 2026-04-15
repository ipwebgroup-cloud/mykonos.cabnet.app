# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.61.00 inquiry-side continuity risk digest`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades the inquiry record screen so queue operators can see linked continuity risk, review timing drift, and continuity posture when a loyalty record already exists.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open a record with a linked loyalty continuity record
- the inquiry record now shows a Continuity risk digest above the main summary shell
- Open linked loyalty and bridge help still work
- tabs, notes, actions, and list behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- keeps linked continuity timing and risk visible from the queue lane
- reduces back-and-forth opening of the loyalty record
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this queue-memory digest pass, the next strong step should be one of:
- add a loyalty-side follow-through risk digest when queue closure and continuity timing drift apart
- expand Workspace Docs into a fuller bridge playbook dashboard
- add list-level bridge summaries only after record-screen guidance settles
