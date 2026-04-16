# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.68.00 bridge-status legends above queue and loyalty lists`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It upgrades both list pages with a compact legend strip that explains the new row-level bridge health, closure-memory, owner-drift, and stale-timing digests so operators can scan the list faster before opening records.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- Backend -> Loyalty Continuity
- both list pages now show a compact bridge-status legend above the list
- existing toolbar actions, filters, and row behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- improves scan speed at the list layer
- explains the newer compact row digests in plain language
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this list legend pass, the next strong step should be one of:
- add compact lane-priority chips above both lists using real current counts
- add list-level route-return memory so help and backlinks feel more contextual
- improve record-open orientation from list rows without widening the row UI again
