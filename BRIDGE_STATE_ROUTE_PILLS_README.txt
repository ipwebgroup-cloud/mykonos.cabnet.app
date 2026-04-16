Bridge State Route Pills Patch

This backend-only patch adds a compact route-state pill strip above both list pages.

Updated files:
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/index.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_bridge_state_route_pills_strip.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_bridge_state_route_pills_strip.htm
- mykonos.cabnet.app/README.md
- mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
- mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

Install:
- extract into /home/cabnet/public_html/
- run: php artisan cache:clear

No schema change.
No plugin refresh required.
No theme import required.
