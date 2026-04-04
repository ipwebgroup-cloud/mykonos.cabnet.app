# Mykonos v6.39.3 Loyalty Create-Form Render-Safe Partial Hotfix Patch

## Package
- `mykonos-cabnet-v6.39.3-loyalty-create-form-render-safe-partial-hotfix-patch.zip`

## Why this patch exists
After loyalty workspace schema activation succeeded, the live Loyalty Continuity list began rendering correctly. The next real blocker appeared on the create screen, where overview partials were still being rendered in create context and at least one older partial assumed a `$record` variable that does not exist there.

## What changed
- added `context: update` to loyalty overview partial fields so they do not render on the create form
- hardened `_finish_handback_post_close_hold_panel.htm` to tolerate create/update context safely by resolving the model from `$record`, `$formModel`, or `$model`
- updated continuity docs for the new hotfix line
- bumped plugin tracking to `2.3.55`

## Install
1. Upload the rooted files into `/home/cabnet/public_html/`
2. Clear cache if needed:
   `php artisan cache:clear`
3. Open backend -> Mykonos Inquiries -> Loyalty Continuity
4. Click **New Loyalty Record** and confirm the create form opens without the undefined-variable crash

## Notes
- No schema change
- No migration required
- No `/plan` change
- No theme change
