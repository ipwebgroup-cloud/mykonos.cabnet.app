# Mykonos Loyalty Workspace v6.7.0

## Patch name
- `finish-lane handback readability and explicit post-close hold framing workspace`

## Patch type
- plugin-only
- render-safe
- no schema change
- no theme change

## What changed
- added a new read-only `Finish-Lane Handback` signal to show who or what the close-side lane should return to next
- added a new read-only `Post-Close Hold` signal to show whether the record can stay in a quiet close-side hold or should return to active human review
- added `Finish Handback Digest` and `Post-Close Hold Frame` readouts on loyalty records
- added a new Overview panel: `Finish-Lane Handback and Post-Close Hold`
- surfaced the new handback and post-close hold cues on the linked inquiry loyalty snapshot
- surfaced the same cues as list-level readable columns for conservative operator scan support
- added `MYKONOS_CONTINUE_PROMPT.md` at the project root for repo-safe continuity reuse
- updated plugin version tracking
- updated the root continuity handoff

## Why this patch exists
The loyalty workspace could already show finish-close posture, reopen ordering, close-side grouping, and the clean exit from finish review.

The remaining operator friction was the quiet return path after that decision: even when the close-side story was readable, operators still had to infer who the lane should hand back to and whether it was safe to leave the record in a quiet post-close hold.

This patch narrows that gap by:
- making the finish-lane handback explicit
- making the post-close hold posture explicit
- keeping the workspace human-owned, plugin-only, and non-automated

## Install note
- upload the changed files under `mykonos.cabnet.app/...`
- no `plugin:refresh` is required
- clear cache only if backend partial output appears stale
