# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.55.00 inquiry-side continuity source digest on linked records`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades the inquiry update screen so operators can immediately see when a saved loyalty continuity record already exists for that inquiry.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open an inquiry with a linked loyalty record
- the inquiry screen now shows a linked continuity digest strip above the main summary shell
- queue and loyalty actions, filters, and form behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves queue-to-continuity awareness on the inquiry record itself
- reduces duplicate continuity handling
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this bridge-visibility pass, the next strong step should be one of:
- add conservative relationship breadcrumbs on the inquiry create/new flow when a continuity record already exists for a return guest pattern
- add a compact dual-owner posture strip when inquiry owner and continuity owner differ
- improve continuity handoff wording inside Workspace Docs without widening the live queue UI
