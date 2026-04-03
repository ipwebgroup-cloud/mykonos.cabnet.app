# Mykonos Loyalty Workspace v6.2.0

## Name
Conservative stewardship queue compression and list-scan aids workspace

## What changed
- added a new **Stewardship Queue Scan** panel on live loyalty records
- added new queue-compression readouts:
  - `queue_compression_band_label`
  - `list_scan_aid_label`
  - `owner_timing_signal_label`
  - `stewardship_queue_compression_digest`
  - `stewardship_queue_scan_frame`
- loyalty list now shows:
  - `Queue Band`
  - `Scan Aid`
- linked inquiry loyalty snapshot now shows:
  - queue band
  - scan aid
  - owner timing
  - queue compression digest
  - queue scan frame

## Why this patch exists
The loyalty line already made finish posture readable, but operators still had to mentally compress the queue themselves.

This patch adds a conservative human-owned queue reading so reopened records, due parked watches, finish-ready packets, and quiet review records can be scanned faster without turning the workspace into automation.

## Scope
- plugin-only
- no schema change
- no theme change
