# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.67.00 list-level stale-timing drift cues across inquiry and loyalty`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list pages with compact stale-timing drift digests so operators can see whether queue and continuity timing are current, overdue, unscheduled, or split across lanes before opening records.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages now show a compact Stale Timing digest column
- current, one-side-stale, both-stale, and unscheduled scenarios render cleanly
- queue and loyalty filters, row links, and actions remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- surfaces timing drift before a record is opened
- improves queue and continuity scan speed
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this list-level stale-timing step, the next strong step should be one of:
- add a small bridge-status legend above both lists so the new row digests read even faster
- add compact list-level linked-lane latest-action previews for faster queue decisions
- improve linked record opening cues without widening the row action surface again
