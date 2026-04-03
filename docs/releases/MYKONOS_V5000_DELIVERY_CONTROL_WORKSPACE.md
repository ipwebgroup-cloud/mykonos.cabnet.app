# Mykonos Inquiry v5.0.0 — Delivery Control Workspace

## Package
- `mykonos-v5.0.0-delivery-control-workspace-rooted-patch.zip`

## What changed
- added a new **Delivery Control** tab to the inquiry update screen
- added three backend-only operator guidance panels:
  - **Delivery Control Workspace**
  - **Live Delivery Blueprint**
  - **Delivery Risk Guardrails**
- this phase is designed to help operators hold the record together under live operational pressure without relying on memory or off-record context

## Why this patch matters
The previous major line introduced **Final Readiness Workspace**, which helps determine whether a record is close to true go-live posture.

The next remaining gap was the live-operating layer: a record can feel ready while still lacking a visible delivery owner, a control checkpoint, or a clean fallback brief if service reality shifts in motion.

This patch gives live delivery handling its own dedicated workspace instead of blurring it across Final Readiness, Scheduling, Partners, Financials, or Closure.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_delivery_control_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_live_delivery_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_delivery_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V5000_DELIVERY_CONTROL_WORKSPACE.md`
- `CHANGELOG.md`

## Install
1. Merge the zip contents into:
   `public_html/mykonos.cabnet.app/`
2. If needed, clear OctoberCMS cache.
3. Open backend → **Mykonos Inquiries**.
4. Open an inquiry record and verify the new **Delivery Control** tab appears.

## Verify
- the inquiry update screen renders normally
- the new **Delivery Control** tab is visible
- all three new panels render without syntax or data-type errors
- no change is introduced to public `/plan`, schema, list filters, or quick actions

## Notes
- backend-only patch
- no schema change
- changed-files-only rooted patch
- zip root is `mykonos.cabnet.app/`
