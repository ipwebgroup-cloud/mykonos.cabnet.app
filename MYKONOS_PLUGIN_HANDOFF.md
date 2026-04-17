# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.80.00 workspace docs continuity-risk explainer`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades Workspace Docs with a compact continuity-risk explainer so operators can see which continuity drift patterns need intervention first before returning to queue or continuity work.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Workspace Docs
- a new continuity-risk explainer block appears near the top of the page
- the explainer summary adapts to the current docs route context
- quick-return chips, route memory, bridge-state legend, quick glossary, lane-attention headline, bridge-health totals, and dashboard attention chips remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves central understanding of the most important continuity drift patterns
- keeps intervention language visible in plain language
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this docs continuity-risk pass, the next strong step should be one of:
- surface queue-only versus continuity-led posture cues inside the docs hero area
- add a small handoff-readiness explainer strip beside the docs dashboard cards
- add compact bridge-state examples that mirror the list-row digests directly
