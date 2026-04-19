MYKONOS PATCH V7.20.00

Title: Inquiry record closure-decision audit strip

Scope
- backend-only
- render-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_decision_audit_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- continuity files updated

Deploy
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear
3. Open Backend -> Inquiries -> any inquiry record
4. Confirm Closure Decision Audit appears after Closure to Reopen Decision
