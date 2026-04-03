# Mykonos Inquiry Plugin v4.8.1 Component Alias Hotfix

## Package
- `mykonos-cabnet-v4.8.1-component-alias-hotfix.zip`

## Why this hotfix exists
The CMS editor and any theme page that expects the component class
`Cabnet\MykonosInquiry\Components\MykonosPlanBridge`
can fail if the plugin only contains `components/PlanBridge.php`.

This hotfix restores the expected component class name through a thin
backward-compatible wrapper, without changing the live inquiry bridge logic.

## What changed
- added `plugins/cabnet/mykonosinquiry/components/MykonosPlanBridge.php`
- the new class extends the existing `PlanBridge` component
- no schema change
- no theme change
- no workflow change

## Result
This restores the intended v41/v2.3 bridge expectation where `/plan`
uses the plugin-backed plan bridge component instead of a theme-only flow.

## Install
1. Upload the changed files into `mykonos.cabnet.app/...`
2. Clear OctoberCMS / application cache if needed
3. Re-open:
   - backend CMS editor
   - `/plan`

## Notes
- `plugin:refresh` is **not** required for this hotfix.
- This is a render and component-resolution fix only.
