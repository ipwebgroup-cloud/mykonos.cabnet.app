# Mykonos Inquiry Plugin v3.6.0 Loyalty Escalation Thresholds and Ownership Matrix Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v3.6.0-loyalty-escalation-thresholds-and-ownership-matrix-workspace-public-html-rooted.zip`

## What changed
- plugin-only major patch
- no schema change
- no theme change
- extends the Loyalty Continuity pre-launch area into a clearer **escalation-thresholds and ownership-matrix workspace**
- adds shared operator-facing panels for:
  - escalation thresholds
  - ownership matrix
- updates the loyalty guarded workspace wording so operators can define who owns continuity review and when a case must be elevated back into higher-touch handling
- updates the root continuity file:
  - `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch matters
The loyalty workspace already defined qualification, timing, segments, treatment lanes, message framing, trigger discipline, and exception-routing. The next practical operator question is who owns each continuity step and when a case must be escalated instead of quietly pushed forward. This patch makes that decision layer explicit without activating storage.

## Install path
- Extract from `/home/cabnet/public_html/`
- This zip is rooted so files land under `mykonos.cabnet.app/...`

## Notes
- no shell commands are required for this patch package
- Inquiry Queue remains the live operational workspace
- Loyalty Continuity remains a guarded pre-launch planning surface until the dedicated storage layer is released
