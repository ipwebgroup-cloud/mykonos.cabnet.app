Mykonos v6.65.00 Closure-Memory Digest Rows

This backend-only patch adds compact closure / handoff memory digest columns to both list screens.

Updated files
- plugins/cabnet/mykonosinquiry/models/inquiry/columns.yaml
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_closure_memory_digest.htm
- plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_list_closure_memory_digest.htm
- README.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

After upload run:
php artisan cache:clear
