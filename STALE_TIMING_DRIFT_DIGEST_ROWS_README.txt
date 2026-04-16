List-level stale-timing drift cues patch

Files changed
- plugins/cabnet/mykonosinquiry/models/inquiry/columns.yaml
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_stale_timing_drift_digest.htm
- plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_list_stale_timing_drift_digest.htm
- README.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Install
- upload rooted files into /home/cabnet/public_html/
- run php artisan cache:clear

Verify
- Inquiry Queue shows compact stale-timing drift digest rows
- Loyalty Continuity shows matching stale-timing drift digest rows
- no filters or actions change
