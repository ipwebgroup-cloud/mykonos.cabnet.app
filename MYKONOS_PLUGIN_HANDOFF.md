# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.74.00 workspace docs quick-return chips`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades Workspace Docs with record-lane quick-return chips that mirror the current route memory and return targets, so operators can jump back to the exact inquiry or continuity lane without rebuilding the route manually.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Workspace Docs
- a new record-lane quick-return strip appears near the top of the page
- opening docs from queue, loyalty, or record-screen help updates the quick-return chips
- docs search, glossary, and return actions remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves docs-to-record return speed
- keeps route memory visible in plain language
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this docs navigation pass, the next strong step should be one of:
- add route-aware quick-return chips to the central docs playbook dashboard cards
- surface current lane attention counts directly inside the docs hero strip
- add a small bridge-state legend inside Workspace Docs so row/list language matches the docs language exactly
