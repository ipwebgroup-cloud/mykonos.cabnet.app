# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.79.00 workspace docs route-aware attention chips`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades Workspace Docs with route-aware attention chips so operators can keep lane pressure, companion-lane posture, and bridge context visible deeper into the docs dashboard before returning to queue or continuity work.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Workspace Docs
- a new dashboard attention chips strip appears near the top of the page
- the chips summary adapts to the current docs route context
- quick-return chips, route memory, bridge-state legend, quick glossary, lane-attention headline, and bridge-health totals remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves route-aware lane guidance deeper into the docs surface
- keeps primary and companion-lane posture visible in plain language
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this docs attention-chips pass, the next strong step should be one of:
- add a compact continuity-risk explainer block near the docs dashboard top
- surface queue-only versus continuity-led posture cues inside the docs hero area
- add a small handoff-readiness explainer strip beside the docs dashboard cards
