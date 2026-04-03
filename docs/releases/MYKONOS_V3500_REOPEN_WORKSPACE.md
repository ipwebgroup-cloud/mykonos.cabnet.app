# Mykonos Inquiry Plugin v3.5.0 Reopen Workspace

## Package
- `mykonos-v3.5.0-reopen-workspace-rooted-patch.zip`

## What changed
- added a new **Reopen** tab to the backend inquiry update screen
- introduced a composite **Reopen Workspace** panel for disciplined reactivation posture
- added **Reactivation Blueprint** guidance so operators can reopen records without losing continuity anchors
- added **Reopen Risk Guardrails** to reduce stale-assumption drift, weak ownership, and fragile second-cycle hand-off posture

## Why this patch matters
The current operator line already supports queue triage, command/action posture, communication shaping, proposal shaping, fulfillment readiness, confirmation posture, and closure discipline.

The next safe major step is to separate **reopen handling** from closure handling. Reopening is not just the inverse of closing. It requires source recovery, ownership clarity, continuity repair, and an explicit second-cycle operating posture.

This patch keeps the change backend-only and production-safe while giving operators a dedicated reactivation workspace.

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_reopen_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_reactivation_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_reopen_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Install
1. Merge the patch into `public_html/mykonos.cabnet.app/`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry record and confirm:
   - **Reopen** tab is visible
   - the three new panels render without layout or partial errors
   - existing tabs and quick actions still behave normally

## Notes
- no schema change
- no theme change
- no `/plan` bridge change
- no list filter expansion
