# Mykonos Inquiry Plugin v2.3.0 — Loyalty Continuity Workspace

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.0-loyalty-continuity-workspace-rooted-patch.zip`

## Why this update matters
The current Mykonos inquiry line already handles:
- plugin-backed `/plan` persistence
- operator review and concierge workflow
- queue actions and follow-up continuity
- extended internal scan panels and recovery workspace discipline

The strongest next major step is to separate long-cycle retention from the active inquiry queue.

This update introduces a dedicated **Loyalty Continuity Workspace** so closed, referral-ready, or return-value candidate records can move into retention handling without blending that logic into VIP or repeat-guest memory.

## What this patch adds

### Inquiry screen additions
- new **Loyalty Workspace Actions** panel on the inquiry update screen
- quick actions to:
  - move an inquiry into Loyalty Continuity
  - mark it referral-ready
  - mark it a return-value candidate
- read-only **Loyalty Continuity Snapshot** panel on the inquiry screen
- direct open-link from the inquiry screen into the loyalty workspace when a linked record exists

### New backend workspace
- new backend controller:
  - `LoyaltyRecords`
- new backend side-menu entry:
  - **Loyalty Continuity**
- separate permissions for loyalty continuity handling

### New persistence layer
- new table:
  - `cabnet_mykonos_loyalty_records`
- new table:
  - `cabnet_mykonos_loyalty_touchpoints`
- one loyalty record can be linked back to its source inquiry
- touchpoints are append-only and retention-focused

### Loyalty workspace fields
- continuity status
- loyalty stage
- referral-ready flag
- return-value tier
- next review date
- last retention contact date
- preferred season
- revisit window
- source summary
- continuity summary
- retention notes
- append-only touchpoint timeline

## Design discipline
This patch is intentionally plugin-only.
It does **not** change the public theme or the `/plan` flow.

It keeps:
- inquiry queue = active operational handling
- loyalty continuity = long-cycle retention and return-value handling
- future VIP / repeat-guest memory = separate layer later

## Install
1. Upload the patch files into the project root so the paths land exactly under:
   - `plugins/cabnet/mykonosinquiry/...`
   - `docs/releases/...`
2. Run:
   - `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Clear cache if needed:
   - `php artisan cache:clear`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open an inquiry record
3. Confirm the **Loyalty Workspace Actions** and **Loyalty Continuity Snapshot** panels appear on the **Internal** tab
4. Click **Move to Loyalty**
5. Confirm a flash success message appears
6. Confirm the snapshot now shows continuity status and an **Open Loyalty Record** link
7. Open backend → **Loyalty Continuity**
8. Confirm the new record exists and links back to the source inquiry
9. Add a loyalty touchpoint note and save
10. Confirm it appears in the append-only history timeline

## Notes
- This is a rooted patch package with repo-style paths.
- It is designed to continue from the live inquiry plugin line documented in the current repository and v41 integration foundation.
- No public theme file is changed in this update.
