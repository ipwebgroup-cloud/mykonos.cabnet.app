# Mykonos Inquiry Plugin v4.1.0 Loyalty Dependency Map and Launch-Decision Register Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v4.1.0-loyalty-dependency-map-and-launch-decision-register-workspace-public-html-rooted.zip`

## What changed
- extended the guarded Loyalty Continuity workspace with two new operator-facing planning panels:
  - dependency map
  - launch decision register
- sharpened pre-launch toolbar wording so the area presents as launch dossier mode while storage remains inactive
- updated the install-state overview so the workspace reads as a fuller activation-governance surface rather than only a cutover shell
- updated the root continuity handoff file for crash-safe continuation

## Why this patch matters
The workspace already covered qualification, governance, suppression, rollback, cutover sequencing, and post-launch review. The next safe step was making the activation dependencies and approval decisions explicit so the future structural release can be staged with less ambiguity. This patch keeps production safe while turning the Loyalty area into a clearer launch-governance surface without enabling storage yet.

## Files included
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_dependency_map_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_launch_decision_register_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Notes
- plugin-only patch
- no schema change
- no theme change
- continues the guarded Loyalty Continuity workspace line safely
