# Mykonos Inquiry Plugin v3.9.0 — Intake Workspace

## Package
- `mykonos-v3.9.0-intake-workspace-rooted-patch.zip`

## What changed
- added a new **Intake** tab to the inquiry update screen
- added **Intake Normalization Workspace**
- added **Field Normalization Blueprint**
- added **Normalization Risk Guardrails**

## Why this patch matters
The current operator workspace already covers planning, communication, proposal, fulfillment, confirmation, closure, reopen, handoff, and recovery. The next missing major phase was a dedicated intake cleanup surface so operators can tighten structured field quality before deeper downstream handling depends on it.

## Install
1. Merge the contents of `mykonos.cabnet.app/` into your live `public_html/mykonos.cabnet.app/` folder.
2. Open backend → **Mykonos Inquiries**.
3. Open an inquiry and confirm the new **Intake** tab renders.

## Verify
- the **Intake** tab appears on the inquiry update screen
- the three new read-only normalization panels render without crashing
- the update screen remains stable and the public `/plan` flow remains untouched

## Notes
- no schema change
- no public theme or `/plan` change
- changed-files-only patch with zip root `mykonos.cabnet.app/`
