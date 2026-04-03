# Mykonos Inquiry Plugin v2.9.0 Loyalty Pilot-Lane And Intent Mapping Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.9.0-loyalty-pilot-lane-and-intent-mapping-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the Loyalty Continuity pre-launch area into a clearer **pilot-lane and intent-mapping workspace**
- adds shared operator-facing panels for:
  - pilot candidate lanes
  - re-engagement intent mapping
- sharpens the workspace overview and toolbar wording so the area reads as a narrower first-pilot planning surface before storage activation
- updates:
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- adds:
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_pilot_candidate_lanes_panel.htm`
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_reengagement_intent_map_panel.htm`
- updates the root handoff file:
  - `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The loyalty workspace had already become useful for transition planning, but it still needed clearer guidance on which kinds of candidates belong in the first live pilot and what kind of future loyalty motion each one should represent. This patch narrows the activation thinking so the eventual structural rollout can start from a cleaner first cohort instead of a vague retention bucket.
