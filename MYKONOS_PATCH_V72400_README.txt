MYKONOS PATCH V7.24.00

Patch: inquiry record minimum evidence to proceed strip

Scope
- backend-only
- render-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_minimum_evidence_to_proceed_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run php artisan cache:clear

Verify
1. Open backend -> Inquiries -> any inquiry record
2. Confirm Minimum Evidence to Proceed appears after Evidence Gap Priority
3. Confirm the strip shows threshold count, missing essentials, and anchor set for the current posture
