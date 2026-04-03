# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current emergency status
- Inquiry workspace remains stable after loyalty partial, render, toolbar, and table-guard hotfixes.
- Loyalty Continuity now opens safely even when the loyalty database tables are not installed.
- The current safe behavior is:
  - inquiry pages continue to work
  - loyalty pages render guarded install-state messaging
  - toolbar actions remain locked until storage exists

## This patch
- Version: `v2.3.12`
- Name: `loyalty install-state workspace polish`
- Type: plugin-only safety patch
- No schema change
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `docs/releases/MYKONOS_V2312_LOYALTY_INSTALL_STATE_WORKSPACE_POLISH_PATCH.md`

## Why this patch exists
The workspace was restored safely, but it still exposed an active-looking toolbar and minimal install-state feedback. This patch makes the current non-installed state more explicit and operator-friendly while keeping the inquiry queue as the live operational surface.

## Safest next direction
- Keep the inquiry queue stable.
- Do not introduce schema work through live hotfixes.
- Continue with plugin-only operator-facing polish until the loyalty storage layer is prepared in a separate controlled release.
