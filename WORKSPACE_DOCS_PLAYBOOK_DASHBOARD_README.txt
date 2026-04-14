Current state assessment

This major update stays on the safe backend-only line already established in the real project state. The live /plan bridge remains untouched, the inquiry and loyalty list screens keep their current render-safe posture, and no workflow or schema behavior changes are introduced.

Instead of widening list UIs again, this step upgrades Workspace Docs into a fuller operator playbook dashboard so operators can confirm route posture, bridge posture, and the correct help family before jumping deeper into queue, continuity, or record screens.

Changes

This rooted patch updates:

mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/helpcenter/index.htm
mykonos.cabnet.app/README.md
mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md
mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md

What changed:

- Workspace Docs now shows an Operator Playbook Dashboard near the top of the page
- the dashboard adds live summary cards for:
  - inquiry queue record count
  - loyalty record count
  - transfer-ready count
  - draft-ready count
- the dashboard adds four direct route cards for:
  - Inquiry Queue
  - Loyalty Continuity
  - Queue-to-loyalty bridge
  - Record screens
- the dashboard adds a current workspace snapshot list in plain language
- continuity files updated to:
  - v6.44.00 workspace docs operator playbook dashboard

What did not change:

- no schema change
- no plugin refresh required
- no theme import required
- no /plan change
- no list filter change
- no row action change
- no queue or loyalty workflow logic change

Commit title

feat: upgrade Workspace Docs into an operator playbook dashboard

Install note

Extract from:

/home/cabnet/public_html/

The zip is already rooted correctly under:

mykonos.cabnet.app/...

This patch is backend-only and safe:

- no schema change
- no plugin refresh required
- no theme import required

Recommended after upload:

php artisan cache:clear

Then verify:

- Backend -> Workspace Docs opens normally
- the new Operator Playbook Dashboard appears near the top of the page
- route cards open Inquiry Queue, Loyalty Continuity, and anchored docs sections correctly
- queue, continuity, transfer-ready, and draft-ready posture cards render without errors
- the existing docs sections, glossary, search, and return actions still work

Strongest next step

The best next safe move is to add compact operator checklist strips to the inquiry and loyalty update screens so record-level work inherits the same playbook direction now visible on the list and docs pages.
