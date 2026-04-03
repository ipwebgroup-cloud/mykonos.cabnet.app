# Mykonos Inquiry Platform v2.6.24 — Operator Workspace Activation Alignment

## Summary
This patch aligns the backend inquiry update screen with the operator workspace partials that already exist in the repository but are not yet all wired into the live `fields.yaml` form layout.

## Why this patch exists
The repo commit history and plugin version line continue through `v2.6.23`, but the current inquiry form only activates part of that Internal-tab operator workspace set.

This patch safely closes that gap without changing schema, list rendering, or the public `/plan` flow.

## Activated Internal-tab panels
- Risk & Sensitivity
- Commercial Posture
- Decision Posture
- Proposal Readiness
- Fulfillment Readiness
- Working Summary Framing
- Guest Confidence Signals

## Changed files
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V264_OPERATOR_WORKSPACE_ACTIVATION_ALIGNMENT.md`

## Non-regression intent
- no schema change
- no public theme change
- no list filter expansion
- no quick-action routing change
- no `/plan` bridge change

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open an existing inquiry record
3. Confirm the Internal tab now includes the seven activated panels above
4. Confirm the update screen still renders normally
5. Confirm saving the inquiry still works normally
6. Confirm the backend list still loads normally

## Packaging note
This patch is designed for changed-files-only rooted delivery.
