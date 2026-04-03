# Mykonos Inquiry Plugin v3.4.0 Loyalty Message Framework and Channel Priority Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.4.0-loyalty-message-framework-and-channel-priority-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the Loyalty Continuity pre-launch area into a clearer message-framework and channel-priority workspace
- adds shared operator-facing panels for:
  - message framework
  - channel-priority map
- sharpens the guarded workspace wording so the area reads as a more usable pilot-communication planning surface before storage activation
- keeps the live Inquiry Queue as the active operational workspace
- updates the root continuity handoff file for crash-safe continuation

## Files included
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_install_state_overview.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_message_framework_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_channel_priority_map_panel.htm`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The loyalty workspace already framed qualification, segmentation, journey-state, intervention, offer, cadence, timing, and return-value logic,
but the first real retention pilot will also depend on message discipline and channel discipline.
This patch adds a simple message framework and channel-priority map so the first continuity wave can be planned with clearer operator rules
without turning on the storage layer yet.

## Safest next direction
- keep Inquiry Queue as the live workflow
- keep Loyalty Continuity in guarded planning mode until the structural storage release is ready
- continue with plugin-only operator-facing patches or prepare a separate explicit storage-install package later
