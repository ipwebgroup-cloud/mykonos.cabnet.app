Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling. The backend line already evolved through operator workflow, concierge lifecycle, backend detail polish, queue actions, list safety, and the newer operator guidance layers.

So instead of risking /plan, schema, or queue logic, this major step upgrades the loyalty create route when a real source inquiry is present.

Changes

This rooted patch updates:

mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/create.htm
mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_create_source_relationship_breadcrumbs.htm
mykonos.cabnet.app/README.md
mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

What changed:

Loyalty create gets a compact source relationship breadcrumb strip when `?source_inquiry_id=` is present
each strip adds:
a clearer heading
three practical relationship cards
plain-language explanation of first-save continuity posture
direct links into the source inquiry, queue search, and bridge help
when the inquiry id does not resolve, the strip explains the mismatch and routes the operator back safely
no create form fields changed
no row actions changed
no filters changed
no schema changed
/plan remains untouched
continuity files updated to:
v6.51.00 loyalty create source relationship breadcrumbs

Commit title

feat: add source relationship breadcrumbs to seeded loyalty create flow

Install note

Extract from:

/home/cabnet/public_html/

The zip is already rooted correctly under:

mykonos.cabnet.app/...

This patch is backend-only and safe:

no schema change
no plugin refresh required
no theme import required

Recommended after upload:

php artisan cache:clear

Then verify:

Backend → Loyalty Continuity → create with a real ?source_inquiry_id=... value shows:
the existing toolbar
a new source relationship breadcrumb strip
the existing plain-language guide below it
Open source inquiry / Back to queue search / Bridge help still open correctly
create form rendering remains unchanged

Strongest next step

The best next major-safe move is to add a compact seeded-transfer checklist near the loyalty create fields so operators can confirm bridge intent, owner clarity, and first follow-through posture before the first save.
