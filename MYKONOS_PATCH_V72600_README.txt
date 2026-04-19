MYKONOS PATCH V7.26.00
Inquiry Record Why Pause First Strip

Scope
- backend-only
- render-only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
- no queue logic change
- no SMTP change

What changed
- added a new inquiry-record strip:
  Why Pause First
- wired the strip into inquiry fields.yaml after Proceed or Pause Recommendation

Install
1. Upload the rooted files preserving mykonos.cabnet.app/...
2. Run:
   php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record
2. Confirm Why Pause First appears after Proceed or Pause Recommendation
3. Confirm it explains the shortest route back to safe proceed state when essentials are missing
