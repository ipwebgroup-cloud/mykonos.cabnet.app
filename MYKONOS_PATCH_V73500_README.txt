MYKONOS PATCH V7.35.00

Title: inquiry record ready after one fix strip

Scope
- backend-only
- render-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_ready_after_one_fix_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install
1. Upload the rooted patch preserving paths under mykonos.cabnet.app/...
2. Clear cache:
   php artisan cache:clear

Verify
1. Open Backend -> Mykonos Inquiries -> any inquiry record
2. Confirm Ready After One Fix appears after Score Recovery Priority
3. Confirm it shows:
   - one-fix verdict
   - projected readiness score
   - why the verdict was reached
   - do-after-fix guidance
   - watch-next guidance
