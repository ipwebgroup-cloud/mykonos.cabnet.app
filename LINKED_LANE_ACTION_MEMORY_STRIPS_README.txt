Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling. The backend line already evolved through operator workflow, concierge lifecycle, backend detail polish, queue actions, list safety, and the newer operator guidance layers.

So instead of risking /plan, schema, or queue logic, this major step upgrades both saved record screens with linked-lane action memory.

Changes

This rooted patch updates:

mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_linked_lane_action_memory_strip.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/update.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_linked_lane_action_memory_strip.htm
mykonos.cabnet.app/README.md
mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

What changed:

- Inquiry update now gets a compact linked-lane action memory strip when a linked loyalty record exists
- Loyalty update now gets a matching linked-lane action memory strip when a real source inquiry is linked
- each strip keeps the newest decisive move from the other lane visible without opening the linked record first
- no schema changed
- /plan remains untouched
