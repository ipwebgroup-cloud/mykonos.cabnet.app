MYKONOS PATCH V7.29.00

Patch: inquiry record recommended queue action summary strip

Scope:
- backend-only
- render-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_recommended_queue_action_summary_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install:
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run php artisan cache:clear
3. Open Backend -> Inquiries -> any inquiry
4. Confirm Recommended Queue Action Summary appears after Proceed Readiness Summary
