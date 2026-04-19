MYKONOS PATCH V73611

Hotfix purpose:
- replace the failing next best action strip with a render-safe version
- remove dependency on Inquiry::getLinkedLoyaltyRecord()

Install:
1. Upload this rooted package to the project root.
2. Extract and overwrite existing files.
3. Run from the project directory:
   php artisan cache:clear

Scope:
- backend-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan change
