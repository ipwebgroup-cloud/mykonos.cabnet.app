# Mykonos Inquiry Plugin v3.7.0 — Recovery Workspace

## Package
- `mykonos-v3.7.0-recovery-workspace-rooted-patch.zip`

## What changed
- added a new **Recovery** tab to the backend inquiry update screen
- added **Recovery Workspace**
- added **Continuity Rebuild Blueprint**
- added **Recovery Risk Guardrails**

## Why this patch matters
The current operator line already supports communication, proposal, fulfillment, confirmation, closure, reopen, and handoff posture. The missing major phase was disciplined record recovery.

This patch adds a dedicated recovery workspace so stalled, fragmented, or drifted inquiries can be rebuilt into one readable continuity packet before they are reopened, handed off, or pushed back into guest-facing motion.

## Install
1. Merge the changed files into:
   `public_html/mykonos.cabnet.app/`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry record
4. Confirm the new **Recovery** tab appears
5. Verify the three read-only panels render correctly

## Notes
- backend-only patch
- no schema change
- no public theme or `/plan` change
- no list/filter expansion
