Mykonos v6.69.00

This rooted patch adds compact lane-priority snapshot strips above both list pages.

Files changed:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/index.htm
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_lane_priority_chips_strip.htm
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_lane_priority_chips_strip.htm
- README.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Deployment:
- upload rooted files into /home/cabnet/public_html/
- run php artisan cache:clear

No schema change
No plugin refresh required
No theme import required
