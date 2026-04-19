MYKONOS PATCH V73606
--------------------
Purpose:
Direct render-safe replacement for the failing workflow summary strip.

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_workflow_summary_strip.htm

Install:
1. Upload this rooted zip to the project root.
2. Extract and overwrite existing files.
3. Clear cache from the project folder:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear
