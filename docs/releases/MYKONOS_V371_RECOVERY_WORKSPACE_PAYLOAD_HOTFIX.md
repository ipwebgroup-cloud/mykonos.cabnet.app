# Mykonos v3.7.1 — Recovery Workspace Payload Hotfix

## What this fixes
The Recovery tab could crash with an `Array to string conversion` error when `payload_json` is already hydrated as an array or object on the inquiry record.

This hotfix normalizes the payload check safely before the panel evaluates raw payload availability.

## Scope
- backend-only
- no schema change
- no public `/plan` change
- no list/filter change

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_recovery_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Result
The inquiry update screen should render normally again, including the Recovery tab, even when `payload_json` is already array-backed by the model layer.
