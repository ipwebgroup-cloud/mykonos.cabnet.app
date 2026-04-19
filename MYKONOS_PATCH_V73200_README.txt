MYKONOS PATCH V7.32.00

Patch: inquiry record queue action timing recap strip

What this patch does
- adds a new backend-only render strip to the inquiry record
- appears after Safest Queue Action Timing
- combines queue action, risk posture, and timing into one final recap

Deployment
1. Upload the rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verification
- Open Backend -> Inquiries -> any inquiry record
- Confirm Queue Action Timing Recap appears after Safest Queue Action Timing
- Confirm it shows queue move, risk and timing, operator cue, and final recap

Notes
- No schema change
- No plugin refresh required
- No theme import required
- No /plan behavior change
