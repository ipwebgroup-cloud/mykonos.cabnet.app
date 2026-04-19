MYKONOS PATCH V72700

Patch: v7.27.00 inquiry record fastest path to proceed strip

Scope
- backend-only
- render-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files included
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_fastest_path_to_proceed_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install
1. Upload rooted files preserving paths under mykonos.cabnet.app/...
2. Clear cache: php artisan cache:clear

Verify
1. Open backend > Mykonos Inquiries > any inquiry
2. Confirm Fastest Path to Proceed appears after Why Pause First
3. Confirm it shows Step 1, Step 2, Step 3, and Operator cue
