# MYKONOS_V6394_LOYALTY_CREATE_FORM_CONTROLLER_PARTIAL_RENDER_SAFE_HOTFIX_PATCH.md

## Package
- `mykonos-cabnet-v6.39.4-loyalty-create-form-controller-partial-render-safe-hotfix-patch.zip`

## Why this patch exists
After loyalty storage activation completed successfully, the live Loyalty Continuity list began rendering correctly.

The remaining blocker shifted to the **create form**:
- controller-added overview/workspace/history partials were still being injected during create mode
- some of those partials expected `$record`
- create mode therefore crashed with `Undefined variable $record`

## What changed
- `controllers/LoyaltyRecords.php`
  - `formExtendFields()` now returns early unless the form context is `update`
  - this keeps the controller-added overview/workspace/history callouts off the create form
- hardened:
  - `_close_handoff_review_exit_panel.htm`
  - `_finish_handback_post_close_hold_panel.htm`
- both partials now safely resolve the model from:
  - `$record`
  - `$formModel`
  - `$model`

## Install
1. Upload the rooted patch into `/home/cabnet/public_html/`
2. From `/home/cabnet/public_html/mykonos.cabnet.app`, run:
   - `php artisan cache:clear`
3. Verify:
   - Backend → Mykonos Inquiries → Loyalty Continuity
   - click **New Loyalty Record**
   - confirm the create form opens without the `$record` error

## Notes
- no schema change
- no migration
- no theme change
- no `/plan` change
- plugin-only render hotfix
