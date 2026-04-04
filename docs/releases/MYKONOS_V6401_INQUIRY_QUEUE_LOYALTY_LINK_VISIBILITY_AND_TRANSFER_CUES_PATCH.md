# Mykonos v6.40.1 Inquiry Queue Loyalty Link Visibility and Transfer Cues Patch

## Package
- `mykonos-cabnet-v6.40.1-inquiry-queue-loyalty-link-visibility-and-transfer-cues-patch.zip`

## Current state
- Loyalty Continuity storage is active.
- The live loyalty list renders.
- The loyalty create form opens safely.
- Inquiry detail already supports direct loyalty actions and prefilled draft opening.

## What changed
- adds inquiry-level loyalty visibility inside the live Inquiry Queue list:
  - `Loyalty Link`
  - `Loyalty Cue`
- adds queue-level loyalty command metrics:
  - `Linked to loyalty`
  - `Ready for loyalty`
- eager-loads linked loyalty records on the inquiry list when the loyalty workspace is active
- keeps the update/detail screen, loyalty workspace, and `/plan` flow untouched

## Why this patch matters
Operators no longer need to open each inquiry detail screen just to understand whether:
- a loyalty record already exists
- the inquiry is ready for continuity transfer
- the safest next move is to open the linked record, create + open a real transfer, or keep the inquiry in the live queue

## Install
1. Upload the rooted patch contents into `/home/cabnet/public_html/`
2. Run:
   `php artisan cache:clear`
3. Open backend → **Mykonos Inquiries**

## Verify
- the inquiry list now shows `Loyalty Link` and `Loyalty Cue`
- the list workspace overview shows `Linked to loyalty` and `Ready for loyalty`
- linked inquiries show a linked loyalty posture instead of a blank queue-only state
- closed inquiries without a linked loyalty record show a transfer-ready cue

## Notes
- no migration
- no schema change
- no theme change
- plugin-only and production-safe
