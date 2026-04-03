# Mykonos Loyalty Continuity Workspace Install Hotfix

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.1-loyalty-install-hotfix-public-html-rooted.zip`

## Why this hotfix exists
The first loyalty workspace patch can throw a backend error on inquiry update pages if the new loyalty tables have not been created yet.

The failure happens because the loyalty snapshot partial tries to query `cabnet_mykonos_loyalty_records` before the migration has been applied.

## What this hotfix changes
- guards the inquiry loyalty snapshot partial so it no longer crashes when the loyalty table is missing
- guards the inquiry loyalty action panel and shows an install message instead of rendering active loyalty buttons too early
- guards the inquiry controller loyalty quick actions and returns a flash error instead of a fatal exception if the loyalty migration has not been run yet

## Required install step
After uploading the loyalty workspace patch, you still must run:

`php artisan plugin:refresh Cabnet.MykonosInquiry`

Then reload the backend page.

## Correct extraction root
Extract this zip from:
- `/home/cabnet/public_html/`

So the files land inside:
- `/home/cabnet/public_html/mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/...`
