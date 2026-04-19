MYKONOS PATCH V73603
Decision Readiness Render Safe Hotfix

What this patch does
- replaces the live _decision_readiness_strip.htm with a render-safe version
- also includes corrected _confidence_strip.htm and _request_completeness_strip.htm when present
- fixes invalid boolean-key array syntax that caused backend ParseError failures

Install
1. Upload this rooted zip to the project root.
2. Extract and overwrite existing files.
3. Clear cache: php artisan cache:clear

No schema change.
No plugin refresh required.
No theme import required.
No /plan behavior change.
