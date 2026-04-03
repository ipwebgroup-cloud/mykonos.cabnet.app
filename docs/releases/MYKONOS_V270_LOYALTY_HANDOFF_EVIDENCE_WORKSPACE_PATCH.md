# Mykonos Inquiry Plugin v2.7.0 Loyalty Handoff Evidence Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.7.0-loyalty-handoff-evidence-workspace-public-html-rooted.zip`

## What changed
- continues the Loyalty Continuity pre-launch workspace as a plugin-only major patch
- no schema change
- no theme change
- adds a stronger operator-facing handoff evidence layer for continuity assessment
- adds a dedicated workspace separation rules panel so continuity remains separate from active inquiry handling and future VIP memory
- adds an activation readiness checklist panel to support a safer first storage release later
- updates the workspace overview and toolbar wording to reflect handoff-evidence mode
- updates the root continuity handoff file for crash-safe continuation

## Files touched
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_handoff_evidence_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_workspace_separation_rules_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_activation_readiness_checklist_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The workspace already explained activation status and transition logic, but it still lacked a tighter operator frame for deciding whether a case truly belongs in long-cycle continuity later on. This patch makes the pre-launch workspace more actionable without introducing tables or new backend risk.
