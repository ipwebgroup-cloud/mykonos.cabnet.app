MYKONOS PATCH V7.17.00
======================

Patch title:
- inquiry record closure-history evidence strip

Scope:
- backend only
- render-only enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_history_evidence_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install:
1. Upload the rooted files preserving mykonos.cabnet.app/... paths
2. Run: php artisan cache:clear

Verify:
1. Open Backend -> Inquiries
2. Open any inquiry record
3. Confirm Closure History Evidence appears below Closure Readiness
4. Confirm the strip shows:
   - closure reason state
   - latest internal note excerpt/state
   - last contacted / follow-up memory
5. Confirm no other inquiry panels disappear
