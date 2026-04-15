# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.60.00 loyalty-side queue memory digest`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades the loyalty record screen so continuity operators can see the latest inquiry-side note, queue owner, queue timing, and closure memory when the record was seeded from a real inquiry.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Loyalty Continuity -> open a record with `source_inquiry_id`
- the loyalty record now shows a Queue memory digest above the main summary shell
- Open source inquiry and bridge help still work
- tabs, notes, actions, and list behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- keeps source inquiry memory visible from the continuity lane
- reduces back-and-forth opening of the queue record
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this queue-memory digest pass, the next strong step should be one of:
- add a compact inquiry-side continuity risk digest when loyalty next review is stale or active after closure
- expand Workspace Docs into a fuller bridge playbook dashboard
- add list-level bridge summaries only after record-screen guidance settles
