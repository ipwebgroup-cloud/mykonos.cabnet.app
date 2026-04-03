# Mykonos Inquiry Platform v2.6.27 — Working Notes Posture Panel

## Summary

This patch adds a read-only **Working Notes Posture** panel to the backend inquiry **Internal** tab.

## Why this patch exists

The Internal tab now provides strong scan-first guidance for workflow, contact posture, proposal shaping, hand-off focus, and closure posture.

The remaining operator friction sits right before the editable **Working Notes** field:

- operators can see many guidance panels
- but the form still drops directly into raw note-writing
- continuity quality still depends on whether the rolling note captures the right facts in the right shape

This patch adds one last backend-only scan surface that helps the active operator write a cleaner rolling note for the next assignee or the next guest touch.

## What this adds

- **Working Notes Posture** panel on the **Internal** tab
- scan-first guidance for:
  - whether the current rolling note is missing anchor facts
  - whether the note is overloaded and should be tightened
  - whether the working summary and working note are aligned
  - what the safest next note-writing move is before editing the field

## Changed files

- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_working_notes_posture_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V267_WORKING_NOTES_POSTURE_PANEL.md`

## Non-regression intent

- no schema change
- no public theme change
- no backend list filter change
- no quick-action routing change
- no `/plan` bridge change

## Verify

1. Open backend → **Mykonos Inquiries**
2. Open an existing inquiry record
3. Open the **Internal** tab
4. Confirm **Working Notes Posture** appears immediately above **Working Notes**
5. Confirm the panel changes sensibly for:
   - a record with no working summary and no working notes
   - a record with a strong summary but weak rolling note
   - a closed record whose rolling note does not reflect the outcome
   - a record whose rolling note is overly long and should be tightened
6. Confirm the update screen still renders normally
7. Confirm the public `/plan` flow remains untouched
