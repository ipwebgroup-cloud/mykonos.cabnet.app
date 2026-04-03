# Mykonos v4.4.0 — Partner Coordination Workspace

## Package
- `mykonos-v4.4.0-partner-coordination-workspace-rooted-patch.zip`

## What changed
- added a new **Partners** tab to the inquiry update screen
- added **Partner Coordination Workspace**
- added **Partner Alignment Blueprint**
- added **Partner Risk Guardrails**
- kept the update backend-only
- no schema change
- no public `/plan` change
- no backend list or filter change

## Why this patch matters
The current operator line already supports supplier readiness, scheduling posture, and guest journey design. The next missing phase was explicit cross-party coordination discipline. This patch gives operators one place to decide whether the record is truly ready for partner-facing motion, how much of the brief is safe to externalize, and what continuity anchors must remain operator-controlled.

## Install
1. Merge the contents of `mykonos.cabnet.app/` into your live app root.
2. Clear application/cache layers if needed.
3. Open backend → **Mykonos Inquiries**.
4. Open an inquiry record and verify the **Partners** tab appears.

## Verify
- the **Partners** tab renders without backend form errors
- **Partner Coordination Workspace** appears first on the tab
- **Partner Alignment Blueprint** appears below it
- **Partner Risk Guardrails** appears below that
- the existing public `/plan` flow, backend list rendering, and quick actions remain unchanged

## Notes
- zip root is `mykonos.cabnet.app/`
- this is a changed-files-only patch
- this patch continues the local workspace sequence after **v4.3.0 — Guest Journey Workspace**
