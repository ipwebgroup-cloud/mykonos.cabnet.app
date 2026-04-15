# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.64.00 bridge-health digest rows`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list screens with compact bridge-health digests so operators can see cross-lane risk and timing posture before opening the linked records.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list screens show a compact Bridge Health digest on each row
- linked, overdue, closed-with-active-continuity, and standalone scenarios render readable cues
- existing actions, filters, and list behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves cross-lane scan speed before opening records
- keeps queue and continuity risk visible on the list layer
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this list-scan bridge pass, the next strong step should be one of:
- add a small closure-memory digest on linked list rows
- add a bridge-risk dashboard section to Workspace Docs
- tighten route-state summaries with stale timing counts
