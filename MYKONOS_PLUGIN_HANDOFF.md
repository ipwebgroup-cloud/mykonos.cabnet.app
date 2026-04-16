# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.71.00 bridge-state route pills above queue and loyalty lists`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list pages with compact route-state pill strips that show current lane posture, active search context, and active filter posture in plain language before operators scan the list rows.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages now show a compact route-state pill strip above the list
- search, filters, and list behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves scan orientation before row review begins
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this route-state strip pass, the next strong step should be one of:
- add compact active-filter count chips into the Workspace Docs dashboard
- add route-aware attention headlines above the record update screens
- improve list-to-record orientation cues without widening row actions
