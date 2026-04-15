Bridge Health Digest Rows v6.64.00

This backend-only patch adds compact bridge-health digest partials to the Inquiry Queue and Loyalty Continuity list rows.

Changed files:
- plugins/cabnet/mykonosinquiry/models/inquiry/columns.yaml
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_bridge_health_digest.htm
- plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_list_bridge_health_digest.htm
- README.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install:
- extract from /home/cabnet/public_html/
- run php artisan cache:clear

Verify:
- Inquiry Queue rows now show Bridge Health digests
- Loyalty Continuity rows now show Bridge Health digests
- record links, filters, and existing row actions still work
