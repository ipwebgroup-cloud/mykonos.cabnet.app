# Mykonos Inquiry Plugin v4.2.0 Scheduling Workspace

## Package
- `mykonos-v4.2.0-scheduling-workspace-rooted-patch.zip`

## What changed
- added a dedicated **Scheduling** tab on the inquiry update screen
- introduced three backend-only operator panels:
  - **Scheduling Workspace**
  - **Timing Coordination Blueprint**
  - **Scheduling Risk Guardrails**
- keeps timing coordination separate from supplier-readiness and guest-facing promise language
- no schema change
- no public `/plan` change
- no risky list/filter expansion

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_scheduling_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_timing_coordination_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_scheduling_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V4200_SCHEDULING_WORKSPACE.md`
- `CHANGELOG.md`

## Notes
- zip root is `mykonos.cabnet.app/`
- merge into `public_html/mykonos.cabnet.app/`
- this patch continues from the local backend workspace line after **v4.1.0 — Supplier Readiness Workspace**
