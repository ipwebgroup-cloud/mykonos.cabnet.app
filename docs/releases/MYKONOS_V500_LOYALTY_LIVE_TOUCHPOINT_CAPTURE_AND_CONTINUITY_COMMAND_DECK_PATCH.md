# Mykonos v5.0.0 Loyalty Live Touchpoint Capture and Continuity Command Deck Patch

## Package
- plugin-only rooted changed-files patch

## What changed
- added a real **Continuity Command Deck** on activated loyalty records with sanctioned actions for:
  - review +14 days
  - review +30 days
  - mark referral-ready
  - promote return value
  - mark dormant
  - reactivate retention
- each command-deck action updates the real loyalty record and appends a system touchpoint so the retention ledger shows why posture changed
- added a real **Live Touchpoint Capture** panel on activated loyalty records with structured entry for:
  - touchpoint type
  - channel
  - outcome
  - touchpoint time
  - next-step time
  - internal/external visibility
  - short narrative
- touchpoint capture now synchronizes key timing fields back onto the loyalty record:
  - `last_retention_contact_at`
  - `next_review_at`
- improved loyalty list usability by surfacing:
  - last touch time
  - latest touchpoint summary
- improved inquiry-side loyalty panels so linked inquiries show the current continuity posture, latest touchpoint, and next review timing
- updated the root handoff file for the new active loyalty line

## Why this patch exists
The previous patch made loyalty activation structurally safe and allowed deliberate inquiry-to-record transfer. The next practical step was to make the activated loyalty record operationally usable without expanding into broad campaign behavior.

This patch gives operators the smallest real action deck and structured touchpoint capture surface needed to run first-wave continuity work inside the live loyalty record itself.

## Install
1. Upload the changed plugin files into `plugins/cabnet/mykonosinquiry`
2. Upload the updated root handoff file into `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
3. Open backend → **Loyalty Continuity**
4. Verify:
   - the loyalty record update screen shows **Continuity Command Deck** on the Workspace tab
   - the History tab shows **Live Touchpoint Capture**
   - saving a structured touchpoint appends a new entry to the timeline
   - command-deck actions append system touchpoints and keep the record readable

## Notes
- no theme change
- no destructive migration
- no schema change
- Inquiry Queue remains the live operational workspace
- this patch assumes the v4.9.0 schema-alignment upgrades have already been applied where loyalty storage is activated
