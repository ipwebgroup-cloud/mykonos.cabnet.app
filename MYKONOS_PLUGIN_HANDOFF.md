# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.59.00 inquiry-side latest continuity touchpoint digest`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It adds a compact digest strip on the inquiry update screen when a linked loyalty continuity record already exists, so queue-side operators can see the newest retention move without opening the loyalty record first.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open an inquiry with a linked loyalty record
- the inquiry record now shows a latest continuity touchpoint digest strip above the main summary shell
- linked loyalty route buttons open correctly
- existing tabs, actions, notes, and form behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves queue-side visibility of continuity activity
- reduces unnecessary back-and-forth between inquiry and loyalty records
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this digest layer, the next strong step should be one of:
- add dual stale-owner-and-timing cues when both ownership and dates are drifting together
- add a compact inquiry-side closure memory strip showing the newest close/reopen reasoning alongside continuity posture
- upgrade the loyalty record with a matching queue-memory digest for the latest inquiry-side operator note
