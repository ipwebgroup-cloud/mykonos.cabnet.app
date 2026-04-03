# Mykonos Loyalty Workspace v6.4.0 Finish-Watch Dashboard Compression and Reopen Queue Cues Workspace Patch

## Package
- `mykonos-cabnet-v6.4.0-finish-watch-dashboard-compression-and-reopen-queue-cues-workspace-patch.zip`

## What changed
- added compressed finish-watch queue readouts for live loyalty records:
  - `finish_watch_signal_label`
  - `reopen_queue_cue_label`
  - `finish_watch_dashboard_digest`
  - `reopen_queue_cue_frame`
- added a new Overview panel:
  - `Finish-Watch Dashboard Compression`
- loyalty list now shows compressed queue cues:
  - `Finish Watch`
  - `Reopen Cue`
- linked inquiry loyalty snapshot now shows:
  - finish watch
  - reopen cue
  - finish-watch dashboard digest
  - reopen queue cue frame

## Why this patch exists
The loyalty line could already show finish dashboards, queue-watch timing, reopen priority, and parked-lane meaning.

The remaining friction was cognitive compression: operators still had to read several separate labels to understand the single queue cue that mattered most.

This patch keeps the workspace narrow and human-owned by compressing that story into one finish-watch signal and one reopen-oriented next cue, while preserving the deeper read-only dashboard detail underneath.

## Notes
- no schema change
- no theme change
- this patch stays plugin-only and keeps reopen handling deliberate, readable, and non-automated
