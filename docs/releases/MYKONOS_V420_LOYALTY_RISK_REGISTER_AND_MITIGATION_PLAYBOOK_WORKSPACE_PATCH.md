# Mykonos Inquiry Plugin v4.2.0 Loyalty Risk Register and Mitigation Playbook Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v4.2.0-loyalty-risk-register-and-mitigation-playbook-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the guarded Loyalty Continuity area into a clearer **risk register and mitigation playbook workspace**
- adds shared operator-facing panels for:
  - risk register
  - mitigation playbook
- keeps the workspace in pre-launch planning mode when loyalty storage is not installed

## Updated files
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## New files
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_risk_register_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_mitigation_playbook_panel.htm`

## Why this patch matters
The loyalty workspace already covered qualification, segmentation, messaging, controls, experiment discipline, cutover order, and launch decisions. The missing piece was a clearer operational view of what could go wrong and how the first live pilot should be protected. This patch adds that risk-and-mitigation layer without changing the live inquiry workflow or introducing the loyalty storage layer.

## Notes
- no shell command is required for understanding this patch note
- this patch continues the safe plugin-only pre-launch workspace line
- the loyalty tables should still arrive only in a separate structural release
