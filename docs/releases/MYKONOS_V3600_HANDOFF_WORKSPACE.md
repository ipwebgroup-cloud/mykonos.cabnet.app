# Mykonos Inquiry Plugin v3.6.0 — Handoff Workspace

## Package
- `mykonos-v3.6.0-handoff-workspace-rooted-patch.zip`

## What changed
- added a new **Handoff** tab to the backend inquiry update screen
- added **Handoff Workspace**
- added **Handoff Packet Blueprint**
- added **Handoff Risk Guardrails**

## Why this patch matters
The current operator line already supports communication, proposal, fulfillment, confirmation, closure, and reopen posture. The missing major phase was disciplined operator transfer.

This patch adds a dedicated handoff workspace so active, paused, or reopened inquiries can be transferred with a readable continuity packet instead of relying on memory, scattered notes, or raw payload inspection.

## Install
1. Merge the changed files into:
   `public_html/mykonos.cabnet.app/`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry record
4. Confirm the new **Handoff** tab appears
5. Verify the three read-only panels render correctly

## Notes
- backend-only patch
- no schema change
- no public theme or `/plan` change
- no list/filter expansion
