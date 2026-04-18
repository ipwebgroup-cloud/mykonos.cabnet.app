MYKONOS v7.16.00 — Inquiry Record Closure-Readiness Strip

Package posture
- backend-only
- render-only enhancement
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Install
1. Upload the rooted files into the project root so paths remain under mykonos.cabnet.app/...
2. Run: php artisan cache:clear
3. Open Backend -> Inquiries -> any saved inquiry
4. Confirm the new Closure Readiness strip appears below Operator Action Recap

Verify
- open an active inquiry and confirm the strip advises keeping the queue active
- open a closed inquiry without a closure reason and confirm the strip calls out thin closure context
- open a well-closed inquiry and confirm the strip shows a settled reference-safe posture
