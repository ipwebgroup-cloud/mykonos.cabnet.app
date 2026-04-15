MYKONOS v6.61.00 — Inquiry-side continuity risk digest

Files in this rooted patch:
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_continuity_risk_digest_strip.htm
- mykonos.cabnet.app/README.md
- mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
- mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

Purpose:
- show linked continuity risk directly on the inquiry update screen
- surface continuity status, stage, owner, next review, and drift cues without opening the loyalty record first
- keep the live /plan bridge, schema, and workflow logic untouched

After upload:
- php artisan cache:clear
