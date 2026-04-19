MYKONOS PATCH V73000

Patch: v7.30.00 inquiry record queue move risk summary strip

Scope
- backend only
- render only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Install
1. Upload the rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verify
1. Open Backend > Mykonos Inquiries > any record
2. Confirm Queue Move Risk Summary appears after Recommended Queue Action Summary
3. Confirm it shows risk label, avoid-now guidance, reduce-risk guidance, and anchor visibility
