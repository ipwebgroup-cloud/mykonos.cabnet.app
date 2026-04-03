# Mykonos v4.7.0 — Approvals Workspace

## Package
- `mykonos-v4.7.0-approvals-workspace-rooted-patch.zip`

## What changed
- added a new **Approvals** tab to the backend inquiry update screen
- added three backend-only operator panels:
  - **Approvals Workspace**
  - **Approval Decision Blueprint**
  - **Approval Risk Guardrails**
- keeps approval/sign-off handling in its own operator space instead of blurring it into Financials, Confirmation, or Closure
- no schema change
- no public `/plan` change
- no backend list/filter change

## Install
1. Merge the patch into `public_html/mykonos.cabnet.app/`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry record
4. Confirm the new **Approvals** tab appears and the three approval panels render without errors

## Notes
- This patch is backend-only.
- This patch continues the local workspace expansion line after **v4.6.0 — Documents Workspace**.
