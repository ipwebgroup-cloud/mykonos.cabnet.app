Mykonos Loyalty Create Seeded Transfer Field Cues

Rooted patch line: v6.53.00 loyalty create seeded transfer field cues

Changed files
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_seeded_transfer_field_cues_strip.htm
- mykonos.cabnet.app/README.md
- mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
- mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

Install
- extract from /home/cabnet/public_html/
- run php artisan cache:clear

Verify
- open loyalty create with ?source_inquiry_id=REAL_ID
- confirm the new seeded transfer checklist strip appears above the form
- confirm source inquiry, queue search, and bridge help links work
- confirm create rendering remains unchanged without source_inquiry_id
