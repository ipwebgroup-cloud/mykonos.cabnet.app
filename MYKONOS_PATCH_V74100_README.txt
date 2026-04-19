MYKONOS PATCH V74100
====================

Patch: v7.41.00 inquiry record post-move watch summary strip

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_post_move_watch_summary_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/FIELDS_V74100_POST_MOVE_WATCH_SUMMARY_SNIPPET.txt

Install:
1. Upload and extract this rooted patch into the project root.
2. Open the snippet file above.
3. Paste the snippet into the live inquiry fields.yaml directly after Final Queue Move Confirmation.
4. Clear cache:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear

Notes:
- no schema change
- no plugin refresh required
- no theme import required
- no /plan change
