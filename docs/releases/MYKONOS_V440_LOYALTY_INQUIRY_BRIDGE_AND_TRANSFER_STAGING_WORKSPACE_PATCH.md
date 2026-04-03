# Mykonos Inquiry Plugin v4.4.0 Loyalty Inquiry Bridge and Transfer Staging Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v4.4.0-loyalty-inquiry-bridge-and-transfer-staging-workspace-public-html-rooted.zip`

## What changed
- extended the Loyalty Continuity pre-launch area with a clearer inquiry transfer bridge layer
- added guarded bridge panels on the Loyalty Continuity workspace:
  - inquiry transfer bridge
  - transfer staging rules
- added safer inquiry-side loyalty partials so operators can evaluate:
  - whether a linked loyalty record exists
  - whether the inquiry still belongs in the active queue
  - whether the record looks transition-ready for long-cycle continuity
- kept all transfer behavior guarded when the loyalty table is absent so the live site remains render-safe
- no theme change
- no schema change

## Why this patch matters
The loyalty line had reached the first structural activation stage, but operators still needed a clear boundary on the inquiry screen itself. This patch establishes that boundary and keeps loyalty as a controlled destination for post-handling continuity instead of letting it blur into active concierge operations.

## Included files
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_inquiry_transfer_bridge_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_transfer_staging_rules_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Notes
- This is a plugin-only major patch.
- It is designed to continue from the guarded loyalty workspace line.
- It intentionally keeps Inquiry Queue as the live operational system of record.
