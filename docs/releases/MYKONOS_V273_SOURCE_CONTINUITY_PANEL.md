# Mykonos Inquiry Plugin v2.6.33 Source Continuity Panel

## Package
- `mykonos-v2.6.33-source-continuity-panel-rooted-patch.zip`

## What changed
- added a new read-only **Source Continuity** panel to the **Source** tab
- surfaces whether the inquiry preserves enough source trail for:
  - campaign/page traceability
  - operator hand-off continuity
  - reopen review
- scans source preservation using:
  - `source_type`
  - `requested_mode`
  - `source_title`
  - `source_slug`
  - `source_url`
  - `request_reference`

## Why this patch matters
The Request, Preferences, Internal, History, and Raw tabs already have scan-first operator guidance. The Source tab was still mostly raw editable fields.

This patch gives operators a safe framing layer before editing source metadata, which helps preserve entry-context continuity without changing persistence logic or risking the public `/plan` bridge.

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_source_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Install
1. Upload the patch files into the matching project paths
2. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Clear cache if needed:
   `php artisan cache:clear`
4. Open backend → **Mykonos Inquiries** → open a record → **Source** tab

## Verify
- the **Source Continuity** panel appears at the top of the Source tab
- it renders without breaking the inquiry update screen
- source fields remain editable underneath
- no change occurs to `/plan`, list rendering, or quick actions

## Notes
- no schema change
- no public theme change
- backend-only, production-safe continuation of the v2.6.x operator workspace line
