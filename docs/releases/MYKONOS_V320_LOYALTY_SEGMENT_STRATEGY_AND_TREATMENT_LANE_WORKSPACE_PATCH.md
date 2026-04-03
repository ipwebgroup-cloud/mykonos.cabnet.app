# Mykonos Inquiry Plugin v3.2.0 Loyalty Segment Strategy and Treatment-Lane Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.2.0-loyalty-segment-strategy-and-treatment-lane-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the guarded Loyalty Continuity workspace into a clearer pre-launch segment-design surface
- adds operator-facing panels for:
  - continuity segment strategy
  - treatment-lane playbook
- keeps the storage-safe guarded workspace model intact while making the first pilot easier to shape into a few explicit continuity lanes
- continues updating the root continuity handoff file

## Updated files
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_segment_strategy_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_treatment_lane_playbook_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The loyalty workspace had already clarified qualification, pilot lanes, intent mapping, offers, cadence, measurement, and return-value, but it still needed a cleaner way to turn those signals into a small number of operator-understandable continuity lanes. This patch adds segment strategy and treatment-lane playbooks so the pre-launch workspace becomes more actionable without enabling the storage layer yet.
