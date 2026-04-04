# Mykonos v6.40.2 Inquiry Queue Direct Loyalty Open and Seeded Draft Actions Patch

## Package
- `mykonos-cabnet-v6.40.2-inquiry-queue-direct-loyalty-open-and-seeded-draft-actions-patch.zip`

## Current state assessment
The loyalty workspace is now schema-ready, list-rendering, and create-form safe. The Inquiry Queue already shows loyalty visibility cues, but operators still have to leave the queue and open inquiry detail before taking the next continuity action.

## What changed
- added a dedicated `Loyalty Actions` lane directly on the Inquiry Queue list
- linked inquiries can now open the live loyalty record directly from the queue
- transfer-ready inquiries can now create and open a live loyalty record directly from the queue
- prefill-ready inquiries can now open a seeded loyalty draft directly from the queue
- secondary action links keep the inquiry context one click away
- queue command board guidance now points operators to the new queue-level loyalty action lane

## Install
1. Upload the rooted patch contents into `/home/cabnet/public_html/`
2. Run:
   `php artisan cache:clear`
3. Open backend -> `Mykonos Inquiries`
4. Verify the Inquiry Queue list shows a `Loyalty Actions` column
5. Verify:
   - linked inquiries show `Open loyalty`
   - transfer-ready inquiries show `Create + open loyalty`
   - prefill-ready inquiries show `Open draft`

## Notes
- plugin-only patch
- no schema change
- no `/plan` change
- no theme change
