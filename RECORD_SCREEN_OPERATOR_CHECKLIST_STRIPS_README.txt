Mykonos v6.45.00 record-screen operator checklist strips

This patch is backend-only.

Updated rooted files:
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_record_operator_checklist_strip.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_record_operator_checklist_strip.htm
- mykonos.cabnet.app/README.md
- mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
- mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

Install from /home/cabnet/public_html/
Then run: php artisan cache:clear

No schema change.
No plugin refresh required.
No theme import required.
