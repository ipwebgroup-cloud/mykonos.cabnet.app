MYKONOS PATCH V7.19.00
Inquiry Record Closure-to-Reopen Decision Strip

Scope
- backend-only
- render-only guidance addition
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
- no queue workflow change

Install
1. Upload rooted files preserving the mykonos.cabnet.app/... paths.
2. Run:
   php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record.
2. Confirm a new "Closure to Reopen Decision" strip appears after Reopen Readiness Evidence.
3. Confirm it shows:
   - one concise decision label
   - closure evidence strength
   - reopen signal strength
   - closure memory, active landing point, and decision cue cards
4. Confirm existing strips remain visible and the form still renders normally.
