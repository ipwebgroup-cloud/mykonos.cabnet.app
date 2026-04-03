# Mykonos Inquiry v5.3.0 — Post-Incident Recovery Workspace

## Package
- `mykonos-v5.3.0-post-incident-recovery-workspace-rooted-patch.zip`

## What changed
- added a new **Incident Recovery** tab on the backend inquiry update screen
- added **Post-Incident Recovery Workspace**
- added **Recovery Re-entry Blueprint**
- added **Post-Incident Risk Guardrails**

## Why this patch matters
The current line already covers live delivery and incident containment. The next gap was what happens after the disruption is contained but before the record can safely re-enter normal operator flow.

This patch gives that recovery phase its own explicit workspace so operators can stabilize the brief, set one clear re-entry checkpoint, and preserve continuity for the next move.

## Install
1. Merge the patch contents into `public_html/mykonos.cabnet.app/`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry record
4. Verify the new **Incident Recovery** tab appears after **Incidents**

## Verify
- the **Incident Recovery** tab renders without backend errors
- the workspace shows stabilized recovery posture based on visible record anchors
- the blueprint and guardrails panels render on the same tab
- no `/plan` flow or backend list behavior changes

## Notes
- backend-only change
- no schema change
- no public theme change
- changed-files-only rooted patch
