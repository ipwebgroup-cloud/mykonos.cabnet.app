# Mykonos Inquiry Plugin v3.9.0 Loyalty Pilot Experiment Ledger and Rollback Criteria Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.9.0-loyalty-pilot-experiment-ledger-and-rollback-criteria-workspace-public-html-rooted.zip`

## What changed
- extended the guarded Loyalty Continuity pre-launch area into a clearer pilot-experiment-ledger and rollback-criteria workspace
- added operator-facing planning panels for:
  - pilot experiment ledger
  - rollback criteria
- updated the loyalty workspace overview and toolbar wording so the area reads as a more controlled pilot-governance surface before storage activation
- updated the root-level handoff file for crash-safe continuity

## Files updated
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_pilot_experiment_ledger_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_rollback_criteria_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The loyalty workspace already described qualification, segmentation, pacing, triggers, suppression, ownership, consent posture, and approval flow, but it still needed a clearer way to document what is actually being tested and when a first live continuity move should be reversed. This patch adds pilot-experiment-ledger and rollback-criteria panels so early activation can stay observable, reversible, and premium-safe.

## Notes
- plugin-only major patch
- no schema change
- no theme change
- continues the guarded pre-launch workspace pattern until the loyalty storage layer is introduced in a dedicated structural release
