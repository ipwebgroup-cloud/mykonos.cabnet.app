# Mykonos v3.8.0 — Planning Workspace

## Package
- `mykonos-v3.8.0-planning-workspace-rooted-patch.zip`

## What changed
- added a new **Planning** tab on the inquiry update screen
- added three new backend-only operator panels:
  - **Planning Workspace**
  - **Next Stage Map Blueprint**
  - **Planning Risk Guardrails**

## Why this patch matters
The current line already supports communication, proposal, fulfillment, confirmation, closure, reopen, handoff, and recovery workspaces. The remaining gap was a dedicated stage-mapping layer between recovery and downstream operator motion.

This patch adds a safe planning phase so operators can sequence the next move with visible ownership, continuity anchors, and checkpoint discipline instead of jumping straight from repaired context into execution-style handling.

## Scope
- backend-only change
- no schema change
- no public `/plan` change
- no list/filter change

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_planning_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_next_stage_map_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_planning_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V3800_PLANNING_WORKSPACE.md`
- `CHANGELOG.md`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open an inquiry record
3. Confirm a new **Planning** tab appears between **Recovery** and **Request**
4. Confirm the three planning panels render without PHP errors
5. Confirm no public `/plan` behavior changed
