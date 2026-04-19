MYKONOS PATCH V7.33.00

Patch: inquiry record queue action readiness score strip

Scope
- backend only
- render only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Install
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Clear cache: php artisan cache:clear

Verify
- Open Backend -> Inquiries -> any inquiry record
- Confirm "Queue Action Readiness Score" appears after "Queue Action Timing Recap"
- Confirm the score, readiness label, support explanation, and anchor checks render normally
