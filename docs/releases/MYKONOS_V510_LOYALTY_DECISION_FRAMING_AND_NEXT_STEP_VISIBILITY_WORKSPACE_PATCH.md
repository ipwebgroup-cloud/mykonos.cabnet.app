# Mykonos Loyalty Decision Framing and Next-Step Visibility Workspace Patch

## Package
- `mykonos-cabnet-v5.1.0-loyalty-decision-framing-and-next-step-visibility-workspace-patch.zip`

## What changed
- improved live loyalty record readability with new computed continuity framing:
  - decision focus
  - next review window label
  - latest outcome digest
  - next-step visibility summary
  - referral / return-value framing summary
  - continuity decision frame
- loyalty list now surfaces:
  - decision focus
  - review window
- loyalty filters now include:
  - loyalty stage
- inquiry-side loyalty panels now show linked record framing:
  - decision focus
  - review window
  - referral / value posture
- no schema change
- no theme change

## Why this patch matters
The v5.0.0 line made the loyalty record live-editable and useful, but operators still had to mentally assemble the most important continuity reading from separate fields and raw touchpoint notes.

This patch reduces that friction by turning the loyalty record into a clearer operator-facing stewardship surface while keeping it deliberately narrow and non-automated.

## Install
1. Upload the changed files into `mykonos.cabnet.app/...`
2. No `plugin:refresh` is required
3. Clear backend cache if field layout changes do not appear immediately

## Verify
1. Open backend → **Loyalty Continuity**
2. Confirm the list now shows **Decision Focus** and **Review Window**
3. Open an activated loyalty record
4. Confirm the Workspace tab shows:
   - **Next-Step Visibility**
   - **Continuity Decision Frame**
   - **Referral / Return-Value Framing**
5. Confirm the History tab shows:
   - **Latest Outcome Digest**
   - **Latest Touchpoint Narrative**
6. Open a linked source inquiry and confirm the loyalty panels now show:
   - **Decision Focus**
   - **Review Window**
   - **Referral / value posture**

## Notes
- This patch continues from the v5.0.0 loyalty command-deck line.
- It is intentionally plugin-only and production-safe.
- It improves readability and decision discipline without expanding into automated campaign tooling.
