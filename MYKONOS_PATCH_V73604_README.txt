MYKONOS PATCH V73604
====================

Patch: decision readiness loyalty method hotfix

Purpose:
- fixes backend inquiry detail render failure caused by calling optional model method getLinkedLoyaltyRecord()
- keeps the strip render-safe by treating loyalty continuity as unavailable when the helper method is missing in the live model state

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_decision_readiness_strip.htm

Install:
1. Upload this rooted zip at the project root.
2. Extract and overwrite existing files.
3. Clear cache from the real project directory:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear

Notes:
- no schema change
- no plugin refresh required
- no theme import required
- no /plan change
