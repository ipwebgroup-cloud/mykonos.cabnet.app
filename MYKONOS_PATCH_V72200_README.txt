MYKONOS PATCH V7.22.00
Inquiry Record Action Confidence Check Strip

Scope
- backend-only
- render-only
- inquiry record enhancement

What changed
- added Action Confidence Check strip
- wired the new strip into the inquiry record form sequence after Next Best Action After Decision
- updated continuity files for the new verified patch line

Operational posture
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
- no queue logic change
- no SMTP change

Deploy
1. Upload rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verify
1. Open Backend -> Inquiries -> any inquiry record
2. Confirm Action Confidence Check appears after Next Best Action After Decision
3. Confirm the strip shows confidence level, support guidance, and visible anchor checks
4. Confirm earlier closure and decision strips remain visible

Suggested commit title
feat: add action confidence check strip to inquiry records
