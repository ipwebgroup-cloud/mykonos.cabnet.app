v6.56.00 dual-owner posture cues across inquiry and loyalty records

Backend-only patch.

Files updated:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_dual_owner_posture_strip.htm
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_dual_owner_posture_strip.htm
- README.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

No schema change. No plugin refresh required. Recommended after upload: php artisan cache:clear
