MYKONOS PATCH V73609

Patch: closure-to-reopen decision loyalty-method hotfix

Purpose:
- Replace plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_to_reopen_decision_strip.htm
- Remove reliance on optional Inquiry::getLinkedLoyaltyRecord()

Install:
1. Upload the rooted zip to /home/cabnet/public_html/mykonos.cabnet.app
2. Extract and overwrite existing files
3. Run:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear

Notes:
- No schema change
- No plugin refresh required
- No theme import required
- No /plan behavior change
