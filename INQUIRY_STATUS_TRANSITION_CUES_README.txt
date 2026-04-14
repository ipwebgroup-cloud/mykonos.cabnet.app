Mykonos Inquiry Platform

Patch line:
v6.47.00 inquiry status transition caution cues

What this patch does:
- adds a compact caution strip above the inquiry update form shell
- keeps reopen and closure decisions more deliberate in plain language
- uses current record values to highlight owner clarity, closure evidence, follow-up readiness, working summary posture, and contact continuity

Safety:
- backend-only
- plugin-only
- no schema change
- no plugin refresh required
- no theme import required

After upload:
php artisan cache:clear
