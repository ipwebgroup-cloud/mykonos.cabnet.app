# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.66.00 list-level owner-drift cues across inquiry and loyalty`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list pages with compact owner-drift digests so operators can see whether queue and continuity ownership are aligned, split, missing, or clearly lane-led before opening records.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages now show a compact Owner Drift digest column
- aligned, split, queue-led, continuity-led, and unassigned scenarios render cleanly
- queue and loyalty filters, row links, and actions remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- surfaces handoff ambiguity before a record is opened
- improves queue and continuity scan speed
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this list-level owner-drift step, the next strong step should be one of:
- add compact list-level stale-timing drift cues so owner and timing drift are visible together
- add a small bridge-status legend above both lists so the new row digests read even faster
- improve linked record opening cues without widening the row action surface again
