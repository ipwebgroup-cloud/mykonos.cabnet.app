# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed.
- The loyalty line now includes a guarded inquiry-side bridge, dry-run transfer scoring, staged loyalty record and touchpoint schema packets, outcome/timing planning, and the first staged touchpoint outcome entry and execution field surfaces.
- The public plan bridge expects the plugin-backed component line to remain intact.

## This patch
- Version: `v4.8.1`
- Name: `component alias hotfix`
- Type: plugin-only hotfix
- Adds a backward-compatible `MykonosPlanBridge` wrapper class so the CMS editor and `/plan` bridge can resolve the expected component class safely
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/components/MykonosPlanBridge.php`
- `docs/releases/MYKONOS_V481_COMPONENT_ALIAS_HOTFIX.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The current plugin/theme line relies on the plugin-backed public plan bridge. The live codebase contains `components/PlanBridge.php`, while some live/editor resolution paths expect `Cabnet\MykonosInquiry\Components\MykonosPlanBridge`. This hotfix restores that expected class name with the smallest safe change.

## Safest next direction
- Verify backend CMS editor loads without the component exception.
- Verify `/plan` loads and submits through the plugin-backed bridge again.
- Continue with plugin-only loyalty/workspace work after the public bridge is confirmed healthy.
