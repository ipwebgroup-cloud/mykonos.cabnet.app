# Mykonos Inquiry Plugin v3.5.0 Loyalty Trigger Library and Exception-Routing Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.5.0-loyalty-trigger-library-and-exception-routing-workspace-public-html-rooted.zip`

## What changed
- extended the guarded Loyalty Continuity workspace with:
  - trigger library planning
  - exception-routing guidance
- updated the pre-launch toolbar wording to match the new operator mode
- refined the install-state overview so the workspace reads as trigger-aware and exception-aware before storage activation
- updated the root continuity handoff file

## Why this patch matters
The loyalty workspace had become strong on qualification, measurement, offer design, messaging, and channel planning. The missing operational layer was
knowing exactly what should count as a valid continuity trigger and what should still be routed away from Loyalty Continuity.

This patch makes the workspace more decisive without changing schema or turning on storage.

## Files touched
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_trigger_library_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_exception_routing_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Notes
- plugin-only patch
- no schema change
- no theme change
- production-safe continuation of the loyalty pre-launch workspace line
