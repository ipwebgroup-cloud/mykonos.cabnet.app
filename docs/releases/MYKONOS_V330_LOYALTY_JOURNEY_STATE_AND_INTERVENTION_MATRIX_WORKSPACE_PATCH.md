# Mykonos Inquiry Plugin v3.3.0 Loyalty Journey-State and Intervention Matrix Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.3.0-loyalty-journey-state-and-intervention-matrix-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the guarded Loyalty Continuity pre-launch area into a clearer **journey-state and intervention-matrix workspace**
- adds new operator-facing panels for:
  - guest journey-state framing
  - intervention matrix
- updates the loyalty workspace pages and toolbars so the pre-launch mode reads as a more operational pilot-design surface before loyalty storage activation

## Files included
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_journey_state_framing_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_intervention_matrix_panel.htm`

## Why this patch matters
The workspace already defined qualification, segmentation, treatment lanes, timing windows, offers, cadence, measurement, and return-value signals.
The remaining gap was operator language around where a record sits in the continuity journey and what kind of move is appropriate next.
This patch adds a practical journey-state frame and an intervention matrix so the first live loyalty pilot can be shaped with lighter, safer, more consistent actions.

## Notes
- The Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely when loyalty storage is not installed.
- The structural storage release should remain a separate, explicit install step.
