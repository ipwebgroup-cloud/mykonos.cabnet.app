MYKONOS PATCH V73607
Closure Readiness loyalty-method hotfix

Purpose:
- Replace the failing closure readiness strip with a conservative render-safe version
- Remove dependency on optional Inquiry::getLinkedLoyaltyRecord() method

Install:
1. Upload this rooted zip at the project root
2. Extract and overwrite existing files
3. Clear cache from the real project directory:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear
