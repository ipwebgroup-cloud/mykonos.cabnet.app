MYKONOS V73605 SAFE RENDER HOTFIX

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_operator_summary_recap_strip.htm
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_decision_readiness_strip.htm

What this fixes:
- replaces the failing Operator Summary Recap strip with a conservative render-safe version
- replaces the Decision Readiness strip with a conservative render-safe version that does not call optional loyalty methods

Install:
1. Upload this rooted zip to the project root.
2. Extract it so the files overwrite the existing plugin partials.
3. Clear cache from the real project folder:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear
