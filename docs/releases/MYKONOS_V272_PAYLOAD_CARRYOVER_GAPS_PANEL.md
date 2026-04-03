# Mykonos Inquiry Plugin v2.6.32 Payload Carryover Gaps Panel

## Package
- `mykonos-v2.6.32-payload-carryover-gaps-panel-rooted-patch.zip`

## What changed
- added a read-only **Payload Carryover Gaps** panel to the **Raw** tab
- placed it between:
  - **Payload Alignment Signals**
  - **Reopen Recovery Cues**
- highlights which preference and logistics anchors still appear only in `payload_json`
- gives operators a continuity-first cue to lift important payload-only facts into:
  - the working summary
  - working notes
  - or a new append-only history note

## Why this patch matters
The current v2.6.x consolidation line already gives operators stronger framing across the Internal, History, and Raw tabs.

The remaining gap was that operators could see raw payload and even compare it to normalized fields, but the screen did not explicitly call out which useful planning cues were still trapped only in payload.

This patch keeps the workflow backend-only and production-safe while improving hand-off and reopen continuity.

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_payload_carryover_gaps_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open an inquiry with a saved payload
3. Open the **Raw** tab
4. Confirm **Payload Carryover Gaps** appears between alignment and reopen cues
5. Confirm it shows which planning anchors are:
   - already visible on the record
   - payload-only
   - or absent on both sides

## Notes
- no schema change
- no theme change
- no list filter change
- no public `/plan` change
