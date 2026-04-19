MYKONOS PATCH V73400

Patch: v7.34.00 inquiry record score recovery priority strip

Scope
- backend-only
- render-only inquiry record enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_score_recovery_priority_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record
2. Confirm Score Recovery Priority appears after Queue Action Readiness Score
3. Confirm it shows the top recovery gap, next best fix, secondary gap, and estimated score lift
