MYKONOS PATCH V73610

Patch: closure decision audit loyalty-method hotfix

This patch replaces the backend inquiry strip:
plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_decision_audit_strip.htm

Purpose:
- remove the failing optional loyalty method call
- keep the strip render-safe
- preserve backend-only guidance behavior

Install:
1. Upload this zip at the project root.
2. Extract and overwrite existing files.
3. Run from the project folder:
   cd /home/cabnet/public_html/mykonos.cabnet.app
   php artisan cache:clear
