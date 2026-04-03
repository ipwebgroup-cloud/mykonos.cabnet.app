# MYKONOS PLUGIN HANDOFF

## Current live continuity checkpoint
- Stable base remains the Mykonos inquiry operator workflow line.
- Current emergency fix line is focused on Loyalty Continuity backend render safety.
- Do not introduce schema changes unless explicitly requested and verified.
- Keep the public `/plan` flow untouched.

## Latest delivered patch
- v2.3.10 loyalty double-toolbar render fix

## What this patch does
- plugin-only
- no schema change
- no theme change
- adds the missing double-underscore toolbar partial expected by the current Loyalty Continuity list configuration:
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`

## Why this was needed
- the loyalty list screen was throwing:
  - `The partial '__toolbar.htm' is not found.`
- the live archive state already contains:
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- the current list configuration/runtime is attempting to resolve `__toolbar.htm`, so this patch satisfies the expected partial name without changing schema or workflow behavior.

## Safest next direction
- verify the Loyalty Continuity list renders
- then continue with small operator-facing polish patches only
- avoid plugin refresh / destructive schema operations during live recovery work
