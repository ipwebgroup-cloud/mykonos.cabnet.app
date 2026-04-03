# Mykonos Loyalty Retention Packet and Evidence Framing Workspace Patch

## Package
- `mykonos-cabnet-v5.2.0-loyalty-retention-packet-and-evidence-framing-workspace-patch.zip`

## What changed
- added live loyalty record packet framing with:
  - continuity evidence strength
  - retention recommendation
  - packet brief
  - evidence frame summary
- added visual Overview panels for:
  - retention packet overview
  - continuity evidence frame
- loyalty list now surfaces:
  - evidence strength
- linked inquiry loyalty panels now show:
  - evidence strength
  - retention recommendation
  - packet brief
- updated the root handoff file for the new active loyalty line
- no schema change
- no theme change

## Why this patch matters
The v5.1.0 line made loyalty records much easier to interpret, but operators still had to scan multiple fields to explain why a record belonged in retention, reactivation, referral, or return-value stewardship.

This patch turns that reasoning into a cleaner operator packet so the loyalty workspace feels more like an app surface and less like a scattered set of notes.

## Install
1. Upload the changed files into `mykonos.cabnet.app/...`
2. No `plugin:refresh` is required
3. Clear backend cache if the new Overview layout does not appear immediately

## Verify
1. Open backend → **Loyalty Continuity**
2. Confirm the list now shows **Evidence**
3. Open an activated loyalty record
4. Confirm the Overview tab now shows:
   - **Retention Packet Overview**
   - **Continuity Evidence Frame**
   - **Continuity Evidence Strength**
   - **Retention Recommendation**
   - **Retention Packet Summary**
   - **Evidence Frame**
5. Open a linked source inquiry and confirm the loyalty panel now shows:
   - **Evidence strength**
   - **Recommendation**
   - **Packet brief**

## Notes
- This patch continues from the v5.1.0 decision-framing line.
- It is intentionally plugin-only and production-safe.
- It improves evidence readability and operator confidence without introducing automation.
