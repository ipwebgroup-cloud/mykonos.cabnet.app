MYKONOS PATCH V73900
====================

Patch line:
- v7.39.00 inquiry record move now or hold strip

Scope:
- backend-only
- render-safe
- no schema change
- no plugin refresh required
- no theme import required
- no /plan change

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_move_now_or_hold_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/FIELDS_V73900_MOVE_NOW_OR_HOLD_SNIPPET.txt

Install:
1. Upload and extract this rooted zip into the project root.
2. Open the snippet file:
   plugins/cabnet/mykonosinquiry/models/inquiry/FIELDS_V73900_MOVE_NOW_OR_HOLD_SNIPPET.txt
3. Paste the block into the live fields.yaml directly after the "Recovery Completion Check" strip block.
4. Clear cache:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear
