MYKONOS PATCH V7.31.00
Patch: inquiry record safest queue action timing strip

Scope
- backend-only
- render-only inquiry record enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
- no queue logic change
- no SMTP change

Files included
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_safest_queue_action_timing_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record
2. Confirm Safest Queue Action Timing appears after Queue Move Risk Summary
3. Confirm the strip shows timing verdict, timing window, watch-before-moving guidance, next timing checkpoint, and timing anchor readiness
