MYKONOS PATCH V73608
Reopen Readiness Evidence loyalty-method hotfix

This hotfix replaces:
plugins/cabnet/mykonosinquiry/controllers/inquiries/_reopen_readiness_evidence_strip.htm

Purpose:
- removes dependency on optional Inquiry::getLinkedLoyaltyRecord()
- keeps the strip backend-only and render-safe
- no schema change
- no plugin refresh required
- no theme import required
- no /plan change

After upload and overwrite, clear cache:
cd /home/cabnet/public_html/mykonos.cabnet.app
php artisan cache:clear
