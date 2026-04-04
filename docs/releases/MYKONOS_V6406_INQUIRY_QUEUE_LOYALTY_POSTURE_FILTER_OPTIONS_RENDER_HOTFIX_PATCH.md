# Mykonos v6.40.6 Inquiry Queue Loyalty Posture Filter Options Render Hotfix Patch

## Package
- `mykonos-cabnet-v6.40.6-inquiry-queue-loyalty-posture-filter-options-render-hotfix-patch.zip`

## Current state
The loyalty workspace is already active and the Inquiry Queue already exposes queue-native loyalty visibility, backlink, actions, and posture filtering.

A runtime issue remained in the `Loyalty Posture` filter popup: the filter options were being resolved through a method string in a context where October could attempt to call a method on a null model object.

## What changed
- simplified `controllers/inquiries/config_list.yaml`
- inlined the `Loyalty Posture` filter options directly in YAML
- preserved the existing `modelScope: applyLoyaltyQueuePosture` behavior
- kept the queue loyalty logic unchanged
- no schema change
- no `/plan` change
- no theme change

## Why this patch matters
This is a conservative render-safety hotfix. It keeps the new queue-side loyalty posture filter but removes the null-model method lookup edge that was triggering the popup error.

## Install
1. Upload the rooted files into `/home/cabnet/public_html/`
2. Run:
   `php artisan cache:clear`
3. Open backend → `Mykonos Inquiries`
4. Open the `Loyalty Posture` filter
5. Confirm the popup renders the filter options instead of throwing an error

## Notes
- No migration is required.
- No `plugin:refresh Cabnet.MykonosInquiry` is required.
- This patch is intentionally plugin-only and production-safe.
