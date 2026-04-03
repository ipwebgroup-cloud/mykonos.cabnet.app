# Mykonos Loyalty Workspace v6.6.0

## Patch name
- `close-handoff grouping and finish-review exit readability workspace`

## Patch type
- plugin-only
- render-safe
- no schema change
- no theme change

## What changed
- added a new read-only `Close Handoff Group` signal to compress close-side records into a narrow human grouping
- added a new read-only `Finish Review Exit` signal to show the cleanest next exit from finish review, parked watch, or reopened close posture
- added a new Overview panel: `Close-Handoff Grouping and Finish-Review Exit`
- added `Close Handoff Digest` and `Finish Review Exit Frame` readouts on loyalty records
- surfaced the new close-handoff and review-exit cues on the linked inquiry loyalty snapshot
- surfaced the same cues as list-level readable columns for conservative operator scan support
- updated plugin version tracking
- updated the root continuity handoff

## Why this patch exists
The loyalty workspace could already show finish-close posture, reopen ordering, queue-watch timing, and finish-watch meaning.

The remaining operator friction was the handoff decision itself: even when the close posture was readable, operators still had to reconstruct what group the record belonged to and what the clean exit from finish review should be.

This patch narrows that gap by:
- grouping the close-side posture into one conservative handoff signal
- stating the clean next finish-review exit explicitly
- keeping the workspace human-owned, plugin-only, and non-automated

## Install note
- upload the changed files under `mykonos.cabnet.app/...`
- no `plugin:refresh` is required
- clear cache only if backend partial output appears stale
