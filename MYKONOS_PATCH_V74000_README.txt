MYKONOS PATCH V74000
====================

Patch: v7.40.00 inquiry record final queue move confirmation strip

This package adds a new backend-only render-safe strip and provides a YAML snippet for manual mounting.

Install
-------
1. Upload this zip to the project root.
2. Extract preserving mykonos.cabnet.app/...
3. Open:
   plugins/cabnet/mykonosinquiry/models/inquiry/FIELDS_V74000_FINAL_QUEUE_MOVE_CONFIRMATION_SNIPPET.txt
4. Paste that block into the live fields.yaml directly after Recovery Completion Check or Move Now or Hold, depending on your current live order.
5. Clear cache:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear

Notes
-----
- no schema change
- no plugin refresh required
- no theme import required
- no /plan change
