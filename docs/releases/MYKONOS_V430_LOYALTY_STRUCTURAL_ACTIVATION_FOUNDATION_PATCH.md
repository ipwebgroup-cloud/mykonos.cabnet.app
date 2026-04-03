# Mykonos Inquiry Plugin v4.3.0 Loyalty Structural Activation Foundation Patch

## Package
- `cabnet-mykonosinquiry-plugin-v4.3.0-loyalty-structural-activation-foundation-public-html-rooted.zip`

## What changed
- adds the first install-ready loyalty schema packet:
  - `plugins/cabnet/mykonosinquiry/updates/create_loyalty_records_table.php`
  - `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- keeps the Loyalty Continuity workspace safe when the loyalty table is still not installed
- upgrades the guarded workspace wording so operators can see that the structural packet is staged but not live yet
- adds workspace panels for:
  - structural activation foundation
  - installable schema packet

## Why this patch matters
The Loyalty Continuity area had matured into a strong planning, qualification, risk, rollout, and cutover workspace, but it still lacked the first real structural packet that a future controlled activation would need.

This patch introduces that packet without changing the public theme flow and without forcing Loyalty Continuity to become the live operational queue before the install step is deliberately executed.

## Files included
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_structural_activation_foundation_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_installable_schema_packet_panel.htm`
- `plugins/cabnet/mykonosinquiry/updates/create_loyalty_records_table.php`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Notes
- plugin-only major patch
- introduces a schema packet but does not require any public theme change
- the live production workspace remains Inquiry Queue until the loyalty storage layer is explicitly activated
