# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.50.00 queue-to-loyalty relationship cues on inquiry and loyalty record screens`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both record screens with compact relationship guidance that explains whether an inquiry should remain queue-owned, move into continuity, or stay as reference history after closure.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open an inquiry
- Backend -> Loyalty Continuity -> open a loyalty record
- both record pages now show a compact relationship cue strip above the existing summary shell
- queue, continuity, notes, actions, and form behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves queue-to-loyalty handoff clarity on the actual record screens
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this relationship-cue pass, the next strong step should be one of:
- add a compact bridge decision snapshot block to the Workspace Docs dashboard using the same real record language
- add conservative relationship breadcrumbs on create flows where source inquiry context exists
- improve cross-record orientation cues without widening the row UI again
