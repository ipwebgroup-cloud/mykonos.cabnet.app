Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling. The backend line already evolved through operator workflow, concierge lifecycle, backend detail polish, queue actions, list safety, and the newer operator guidance layers.

So instead of risking /plan, schema, or queue logic, this major step upgrades the loyalty update screen when a saved source inquiry already exists and inquiry-side memory should be visible immediately from the continuity lane.

Changes

This rooted patch updates:

mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_queue_memory_digest_strip.htm
mykonos.cabnet.app/README.md
mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md
mykonos.cabnet.app/LOYALTY_QUEUE_MEMORY_DIGEST_README.txt

What changed:

- Loyalty update now gets a compact queue-memory digest strip when a real source inquiry is linked
- the strip keeps visible the latest inquiry-side note or closure reasoning
- the strip also shows queue owner, queue follow-up, queue status, and last contact posture
- direct links open the source inquiry, inquiry list, and bridge help
- records without source_inquiry_id remain unchanged

What did not change:

- no schema change
- no plugin refresh required
- no theme import required
- no /plan change
- no row action change
- no list filter change
- no queue or loyalty workflow logic change
