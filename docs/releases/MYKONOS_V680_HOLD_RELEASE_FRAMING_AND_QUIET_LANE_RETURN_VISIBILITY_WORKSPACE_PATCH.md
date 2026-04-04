# Mykonos Loyalty Workspace v6.8.0 Hold-Release Framing and Quiet-Lane Return Visibility Patch

## Patch
- `v6.8.0 hold-release framing and quiet-lane return visibility workspace`

## Type
- plugin-only
- render-safe
- no schema change
- no theme change

## What changed
This patch continues the guarded Loyalty Continuity Workspace after the finish-lane handback and post-close hold step.

It adds:

- `Hold Release Cue`
- `Quiet-Lane Return`
- `Hold-Release Digest`
- `Quiet-Lane Return Frame`
- a new Overview partial:
  - `Hold-Release Framing and Quiet-Lane Return`
- linked inquiry loyalty snapshot visibility for the new cues
- list-level scan columns for:
  - `Hold Release`
  - `Quiet Return`

## Why this patch exists
The workspace could already show finish handback, post-close hold, close handoff, and finish-review exit.

The remaining friction was the quiet hold itself:
operators could see that a record was sitting in a conservative post-close posture, but still had to infer when that hold should end and which human lane it should return to next.

This patch keeps the lane human-owned and readable by making hold release and quiet-lane return explicit without widening into automation.

## Install
1. Upload the changed rooted files into:
   - `mykonos.cabnet.app/...`
2. No `plugin:refresh` is required
3. Clear cache only if backend output appears stale

## Verify
1. Open backend → Loyalty Records
2. Confirm new Overview readouts appear:
   - `Hold Release Cue`
   - `Quiet-Lane Return`
3. Confirm the new panel renders:
   - `Hold-Release Framing and Quiet-Lane Return`
4. Confirm the linked inquiry continuity snapshot shows:
   - `Hold release`
   - `Quiet return`
5. Confirm the list shows:
   - `Hold Release`
   - `Quiet Return`
