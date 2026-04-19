MYKONOS PATCH V7.18.00
======================

Patch title:
- inquiry record reopen-readiness evidence strip

Scope:
- backend only
- render-only enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files included:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_reopen_readiness_evidence_strip.htm
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
3. Confirm Reopen Readiness Evidence appears below Closure History Evidence
4. Confirm the strip shows:
   - closure trail state
   - latest internal note cue/state
   - owner / last contacted / follow-up landing point
5. Confirm no other inquiry panels disappear
