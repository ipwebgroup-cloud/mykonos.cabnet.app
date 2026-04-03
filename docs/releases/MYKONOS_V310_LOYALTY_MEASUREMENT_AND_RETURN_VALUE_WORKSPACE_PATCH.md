# Mykonos Inquiry Plugin v3.1.0 Loyalty Measurement and Return-Value Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.1.0-loyalty-measurement-and-return-value-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the guarded Loyalty Continuity workspace into a clearer pre-launch measurement surface
- adds operator-facing panels for:
  - continuity measurement
  - return-value signals
- keeps the storage-safe guarded workspace model intact while making the area more commercially actionable before loyalty tables are activated
- continues updating the root continuity handoff file

## Updated files
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_measurement_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_return_value_signals_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The loyalty workspace already described activation gates, pilot lanes, intent mapping, offers, and cadence. The next missing piece was a clearer way to decide whether a small continuity pilot would be measurable and worth activating at all. This patch adds measurement and return-value framing so the pre-launch workspace becomes more operationally decisive without enabling the storage layer yet.
