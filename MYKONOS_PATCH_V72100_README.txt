MYKONOS V7.21.00 — INQUIRY RECORD NEXT BEST ACTION AFTER DECISION STRIP

Scope
- backend-only
- render-only guidance enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
- no queue logic change
- no SMTP change

What changed
- added a compact "Next Best Action After Decision" strip to the inquiry record
- turns the closure / reopen decision posture into one immediate operator move:
  - keep active landing point visible
  - reopen with owner and dated landing point
  - preserve closure and wait for a real trigger
  - add one clean note before changing state

Install
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record
2. Confirm "Next Best Action After Decision" appears after "Closure Decision Audit"
3. Confirm it shows:
   - do now
   - avoid now
   - operator cue
4. Confirm earlier decision and evidence strips remain visible
