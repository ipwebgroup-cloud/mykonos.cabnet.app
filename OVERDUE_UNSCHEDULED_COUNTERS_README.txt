Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling.

Changes

This rooted patch updates:

mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/index.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_overdue_unscheduled_counters_strip.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/index.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_overdue_unscheduled_counters_strip.htm
mykonos.cabnet.app/README.md
mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

What changed:
- compact overdue versus unscheduled counters now appear above both list screens
- both strips use real current queue and continuity timing counts
- no schema or workflow behavior changed
