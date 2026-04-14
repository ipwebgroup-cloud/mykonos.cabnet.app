# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.51.00 loyalty create source relationship breadcrumbs`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades the loyalty create route so inquiry-backed continuity drafts show a clearer source relationship breadcrumb strip before the first save.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Loyalty Continuity -> create
- open the create route with a real `?source_inquiry_id=` value
- confirm the new source relationship breadcrumb strip appears above the plain-language guide
- confirm the source inquiry, queue search, and bridge help actions open correctly
- create flow and form rendering remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves create-route relationship clarity before first save
- reduces bridge mistakes when opening continuity from the queue
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this create-route relationship pass, the next strong step should be one of:
- add a compact seeded-transfer checklist strip near the loyalty create form fields
- improve create-to-update continuity cues immediately after the first save
- extend the same conservative relationship language into any other create flow that carries real source context
