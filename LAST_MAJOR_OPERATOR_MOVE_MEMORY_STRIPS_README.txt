Mykonos Inquiry Plugin
v6.49.00 last major operator move memory strips

This backend-only patch adds a compact memory strip above both update screens.

Files changed
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_last_major_operator_move_strip.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_last_major_operator_move_strip.htm
- mykonos.cabnet.app/README.md
- mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
- mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md
- mykonos.cabnet.app/LAST_MAJOR_OPERATOR_MOVE_MEMORY_STRIPS_README.txt

Install
- Upload rooted files into /home/cabnet/public_html/
- Run: php artisan cache:clear

No schema change.
No plugin refresh required.
No theme import required.
