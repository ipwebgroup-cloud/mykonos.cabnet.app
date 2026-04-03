# MYKONOS PLUGIN HANDOFF

Current live patch line: v2.3.9 loyalty toolbar restore.

## Current objective
Stabilize the Loyalty Continuity backend workspace as a separate retention layer without disturbing the stable inquiry queue and operator workflow.

## Latest patch delivered
- v2.3.9 loyalty toolbar restore

## What this patch fixes
- restores the missing loyaltyrecords toolbar partial required by the backend list controller
- resolves the partial-not-found crash on `/admin/cabnet/mykonosinquiry/loyaltyrecords`
- keeps prior loyalty safety guards and render templates in place

## Live safety notes
- keep changes plugin-only unless a theme change is explicitly required
- avoid destructive refresh/reset flows on the live project
- prefer small backend rendering fixes over broad rewrites

## Next likely step
- improve the Loyalty Continuity list usefulness with safe operator-facing columns, empty-state guidance, and conservative filters only after the page is fully stable
