# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current emergency status
- Inquiry workspace has been kept stable after loyalty partial and render hotfixes.
- Loyalty Continuity UI routes now exist, but the loyalty database table is still not installed on the live environment.
- The current safe behavior is:
  - inquiry pages continue to work
  - loyalty pages render a guarded message instead of crashing

## This patch
- Version: `v2.3.11`
- Name: `loyalty workspace table guard`
- Type: plugin-only safety patch
- No schema change
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `docs/releases/MYKONOS_V2311_LOYALTY_WORKSPACE_TABLE_GUARD_PATCH.md`

## Why this patch exists
The Loyalty Continuity backend page advanced past the earlier blank-page and missing-toolbar failures, but then failed on direct database list loading because `cabnet_mykonos_loyalty_records` does not exist yet in the live database.

This patch guards the loyalty controller views so the backend remains usable without forcing destructive plugin refresh behavior.

## Safest next direction
- Keep the inquiry queue stable.
- Do not broaden loyalty behavior until the real loyalty migration strategy is confirmed against the live database state.
- Continue with plugin-only, production-safe guardrail patches.
