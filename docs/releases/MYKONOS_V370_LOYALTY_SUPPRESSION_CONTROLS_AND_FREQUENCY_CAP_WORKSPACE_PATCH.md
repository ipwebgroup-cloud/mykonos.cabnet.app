# Mykonos Inquiry Plugin v3.7.0 Loyalty Suppression Controls and Frequency-Cap Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.7.0-loyalty-suppression-controls-and-frequency-cap-workspace-public-html-rooted.zip`

## What changed
- extended the guarded Loyalty Continuity pre-launch area into a clearer suppression-controls and frequency-cap workspace
- added operator-facing planning panels for:
  - suppression controls
  - frequency-cap rules
- updated the loyalty workspace overview and toolbar wording so the area reads as a more disciplined pilot-planning surface before storage activation
- updated the root-level handoff file for crash-safe continuity

## Files updated
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_suppression_controls_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_frequency_cap_rules_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The loyalty workspace already defined who may be a fit for continuity and how a pilot could be structured, but it still needed tighter rules for who must be suppressed and how often continuity should speak. This patch adds conservative stop-rules and pacing guidance so future activation remains premium, deliberate, and safe.

## Notes
- plugin-only major patch
- no schema change
- no theme change
- continues the guarded pre-launch workspace pattern until the loyalty storage layer is introduced in a dedicated structural release
