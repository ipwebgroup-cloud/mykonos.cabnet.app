Current state assessment

This major update stays on the safe backend-only line already established from the real project state. It does not touch /plan, schema, list filters, queue logic, or continuity workflow behavior.

Instead, it adds compact relationship cue strips to the inquiry and loyalty record screens so operators can see whether the request should remain queue-owned, move into continuity, or stay as reference history.

Changes

This rooted patch updates:

mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_queue_loyalty_relationship_cue_strip.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_source_relationship_cue_strip.htm
mykonos.cabnet.app/README.md
mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

Recommended after upload:
php artisan cache:clear
