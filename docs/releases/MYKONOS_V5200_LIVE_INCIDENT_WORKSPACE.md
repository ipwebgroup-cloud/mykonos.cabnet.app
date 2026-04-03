# Mykonos Inquiry v5.2.0 — Live Incident Workspace

## Package
- `mykonos-v5.2.0-live-incident-workspace-rooted-patch.zip`

## What changed
- added a new **Incidents** tab to the inquiry update screen
- added **Live Incident Workspace** for disruption control, visible ownership, and fallback brief framing
- added **Incident Response Blueprint** to keep live issues anchored to one containment brief, one control checkpoint, and one clean message path
- added **Incident Risk Guardrails** to reduce ownership blur, off-record escalation, checkpoint loss, and fragile live-issue handling

## Why this patch matters
The current workflow already covers final readiness, delivery control, and service-day control.

The remaining gap was explicit incident handling when live service reality breaks away from the planned path. This patch gives operators a dedicated incident-control layer without changing schema, public flow, or backend list stability.

## Install
1. Merge the patch into `public_html/mykonos.cabnet.app/`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry and verify the **Incidents** tab renders
4. Confirm the new panels appear:
   - **Live Incident Workspace**
   - **Incident Response Blueprint**
   - **Incident Risk Guardrails**

## Notes
- backend-only change
- no schema change
- no `/plan` change
- no backend list/filter change
