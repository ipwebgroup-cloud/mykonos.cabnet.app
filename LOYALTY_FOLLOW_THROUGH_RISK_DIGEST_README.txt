Loyalty-side follow-through risk digest

Files changed:
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_follow_through_risk_digest_strip.htm
- README.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

What it does:
- adds a compact risk digest above the loyalty update shell when source_inquiry_id is present
- compares source inquiry closure posture with continuity next-review timing
- shows plain-language operator cues for healthy, stale, or unscheduled continuity follow-through

Install:
- upload into /home/cabnet/public_html/
- run php artisan cache:clear
