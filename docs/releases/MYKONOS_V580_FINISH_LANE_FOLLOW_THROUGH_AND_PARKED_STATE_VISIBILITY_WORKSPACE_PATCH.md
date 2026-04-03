# Mykonos Loyalty Workspace v5.8.0 Patch

## Package
- `mykonos-cabnet-v5.8.0-finish-lane-follow-through-and-parked-state-visibility-workspace-patch.zip`

## What changed
- added a new **Finish Lane Follow-through** workbench on live loyalty records
- added operator actions for:
  - Park reactivation lane
  - Park referral lane
  - Park return-value lane
  - Reopen finish lane
- added new live readouts:
  - `finish_lane_status_label`
  - `latest_finish_lane_label`
  - `parked_finish_window_label`
  - `finish_lane_snapshot_summary`
  - `finish_lane_follow_through_frame`
- linked inquiry loyalty snapshots now show:
  - finish lane status
  - parked finish window
  - finish lane frame
- loyalty list now shows:
  - Finish Lane
- closure packets now lead into an explicit parked stewardship state instead of remaining implied

## Why this patch matters
The current loyalty line could already prepare closure packets and recommend a finish lane, but operators still had to infer whether that finish lane was actually parked or reopened.

This patch keeps the loyalty workspace plugin-only and human-owned while making the finish state easier to read, park deliberately, and reopen only on new proof.

## Install
1. Extract from `/home/cabnet/public_html/`
2. Confirm files land under `mykonos.cabnet.app/...`
3. Clear backend cache if the new workspace panel does not appear immediately

## Notes
- No theme change
- No schema change
- No `plugin:refresh` required
