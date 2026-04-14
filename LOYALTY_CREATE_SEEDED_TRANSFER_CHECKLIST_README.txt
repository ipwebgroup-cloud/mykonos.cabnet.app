Loyalty Create Seeded Transfer Checklist Strip

This backend-only patch adds a compact first-save checklist to the loyalty create route when source_inquiry_id is present.

Files updated:
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_seeded_transfer_checklist_strip.htm
- mykonos.cabnet.app/README.md
- mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
- mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

Install:
- extract from /home/cabnet/public_html/
- run php artisan cache:clear

No schema change.
No plugin refresh required.
No theme import required.
