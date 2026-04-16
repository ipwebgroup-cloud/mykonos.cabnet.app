# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.72.00 workspace docs active-filter count chips`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades the Workspace Docs page with a compact active-filter count chip strip so operators can see the current route posture and any incoming search or filter context directly on the central docs surface.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Workspace Docs
- the page now shows an active-filter count chip strip near the top
- opening docs from filtered or searched list routes shows readable context chips
- docs search, glossary, and return actions remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves route-context awareness on the central docs surface
- reduces confusion when opening docs from filtered list routes
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this docs-context pass, the next strong step should be one of:
- add compact active-filter count chips to the Workspace Docs playbook dashboard metrics area
- add a small route-state memory strip on the docs page for linked record help entries
- improve docs-to-list return cues without widening row UI again
