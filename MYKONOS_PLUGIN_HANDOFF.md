# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.75.00 workspace docs bridge-state legend`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades Workspace Docs with a compact bridge-state legend so the list-row language, record-screen language, and docs language all stay aligned for operators.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Workspace Docs
- a new bridge-state legend appears near the top of the page
- the legend summary adapts to the current docs route context
- docs search, glossary, and return actions remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves scan consistency across queue, continuity, and docs
- reduces label drift between lists and record screens
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this shared-language pass, the next strong step should be one of:
- add route-aware attention chips inside the Workspace Docs dashboard cards
- surface bridge-health totals in the docs hero area
- add a small quick glossary block for queue-led, continuity-led, transfer-ready, and draft-ready language
