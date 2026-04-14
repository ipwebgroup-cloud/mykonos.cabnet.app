# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.49.00 last major operator move memory strips`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both record screens with a compact memory strip so the latest decisive operator move stays visible without opening deeper history tabs first.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open any inquiry
- Backend -> Loyalty Continuity -> open any record
- both record screens now show a last major operator move strip above the main summary shell
- existing tabs, actions, notes, and workflow controls remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- keeps decisive context visible at record level
- reduces the need to open history blindly
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this memory-strip pass, the next strong step should be one of:
- add compact relationship cues between inquiry closure posture and loyalty follow-through readiness
- improve record-to-list return orientation without widening the form shell again
- expand Workspace Docs into a deeper record-decision playbook index
