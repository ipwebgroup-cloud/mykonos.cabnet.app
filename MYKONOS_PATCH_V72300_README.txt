MYKONOS PATCH V7.23.00
Inquiry Record Evidence Gap Priority Strip

Scope
- backend-only
- render-only enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
- no queue logic change
- no SMTP change

What changed
- added Evidence Gap Priority strip to the inquiry record
- highlights the single highest-value missing continuity anchor first
- also surfaces a secondary gap so operators know what matters next after the top fix

Install
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record
2. Confirm Evidence Gap Priority appears after Action Confidence Check
3. Confirm it shows top gap, resolve-first guidance, and a secondary gap
4. Confirm earlier strips remain visible
