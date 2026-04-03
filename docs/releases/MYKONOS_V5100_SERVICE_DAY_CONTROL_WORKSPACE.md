# Mykonos Inquiry v5.1.0 — Service-Day Control Workspace

## Package
- `mykonos-v5.1.0-service-day-control-workspace-rooted-patch.zip`

## What changed
- added a new **Service Day** tab to the inquiry update screen
- added three backend-only operator guidance panels:
  - **Service-Day Control Workspace**
  - **Service-Day Execution Blueprint**
  - **Service-Day Risk Guardrails**
- this phase is designed to help operators keep same-day execution readable and controllable when the day starts moving quickly

## Why this patch matters
The previous major line introduced **Delivery Control Workspace**, which helps hold the record together under live operational pressure.

The next remaining gap was the true day-of execution layer: a record can feel operationally stable while still lacking a visible same-day owner, a first escalation checkpoint, or a clean fallback brief when live service reality starts changing.

This patch gives same-day execution its own dedicated workspace instead of blurring it across Delivery Control, Scheduling, Journey, Partners, or Closure.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_service_day_control_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_service_day_execution_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_service_day_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V5100_SERVICE_DAY_CONTROL_WORKSPACE.md`
- `CHANGELOG.md`

## Install
1. Merge the zip contents into:
   `public_html/mykonos.cabnet.app/`
2. If needed, clear OctoberCMS cache.
3. Open backend → **Mykonos Inquiries**.
4. Open an inquiry record and verify the new **Service Day** tab appears.

## Verify
- the inquiry update screen renders normally
- the new **Service Day** tab is visible
- all three new panels render without syntax or data-type errors
- no change is introduced to public `/plan`, schema, list filters, or quick actions

## Notes
- backend-only patch
- no schema change
- changed-files-only rooted patch
- zip root is `mykonos.cabnet.app/`
