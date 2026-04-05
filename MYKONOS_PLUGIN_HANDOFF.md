# MYKONOS_PLUGIN_HANDOFF.md

## Project
Mykonos Cabnet OctoberCMS inquiry project

## Active root
- `mykonos.cabnet.app`

## Active plugin
- `plugins/cabnet/mykonosinquiry`

## Continuity status
This file is continuity-critical.

In any new chat:
1. inspect the latest uploaded rooted project archive / latest rooted patch zip first
2. inspect this file second
3. use the GitHub repo only as a secondary comparison reference
4. if older notes conflict with the real uploaded files, prefer the real uploaded files

Repo reference:
- `https://github.com/ipwebgroup-cloud/mykonos.cabnet.app`

---

## Core operating rule
Treat the latest real uploaded rooted project state as the source of truth.

Do **not** restart from older patch notes alone.
Do **not** rewind to older v2.x assumptions unless the uploaded files clearly show that state.
Do **not** invent new architecture that is not present in the real files.

---

## Stable project direction
This is a real OctoberCMS inquiry platform, not just a theme.

Stable direction:
- public luxury frontend
- mobile-first `/plan` inquiry flow
- DB-backed inquiry persistence through the plugin
- backend inquiry queue and operator workflow
- guarded Loyalty Continuity Workspace
- safe plugin/theme integration
- safe incremental development without breaking live operations

---

## Public flow guardrail
The `/plan` flow must remain on the plugin-backed bridge direction established from the v41 integration line.

That means:
- `/plan` saves through the plugin, not a theme-only email handler
- email continuity to `mykonos@cabnet.app` remains part of the public process
- do **not** introduce a separate theme-only internal inquiry system
- do **not** casually modify the public flow unless the real uploaded files clearly require a public fix

---

## Live operational workspace
- **Inquiry Queue**

This remains the live operational workspace and must stay stable first.

Preserve first:
- backend inquiry list
- backend inquiry update/detail screen
- loyalty continuity workspace rendering
- `/plan` public bridge
- October backend/editor rendering

---

## Current development line
The current long-running line remains the guarded:

- **Loyalty Continuity Workspace**

But the immediate operational priority is now explicit:
- the loyalty workspace is now schema-ready, rendering its live list view, and the create form opens cleanly
- the Inquiry Queue already exposes loyalty link visibility, backlink summaries, direct queue actions, posture filtering, compact transfer-count framing, and filter-mirror guidance
- the live loyalty list now shows empty-state guidance when no records exist
- the active refinement is now to optimize the centralized right-side docs/help/glossary rail so it reads like a real backend side column, with search, faster scanning, and cleaner section navigation across the active plugin screens

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.20 right help rail search filter and navigation optimization patch`
- plugin tracking `2.3.87`

This patch does not change schema and does not touch `/plan`.
It keeps the Inquiry Queue and Loyalty Continuity workflow intact while improving the centralized right-side help rail with a search filter, quick section jumps, responsive sizing, and scan-first section filtering on the active plugin backend pages: Inquiry Queue, Loyalty Continuity list, and loyalty create/update screens.

---

## Deployment note
For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

Then verify:

- Backend -> Mykonos Inquiries -> Loyalty Continuity
- click `New Loyalty Record` and confirm create opens cleanly
- open `/admin/cabnet/mykonosinquiry/loyaltyrecords/create?source_inquiry_id=REAL_ID` and confirm the create screen shows a source inquiry summary with `Open inquiry` and `Back to queue search`
- open `/admin/cabnet/mykonosinquiry/loyaltyrecords/create?source_inquiry_id=123` with a non-existing id and confirm the create screen shows a safe lookup warning instead of pretending prefill is active
- open existing loyalty records such as `/admin/cabnet/mykonosinquiry/loyaltyrecords/update/3` and `/admin/cabnet/mykonosinquiry/loyaltyrecords/update/4` and confirm the pages render instead of throwing `Undefined variable $record`
- confirm hold / quiet-lane / resurfacing / checkpoint / close-handoff continuity panels load without PHP variable errors
- open an existing loyalty record and confirm a compact `Source-context digest` appears above the source inquiry panel on the Overview tab
- open the same loyalty record on the `Workspace` tab and confirm a matching `Workspace source-context digest` appears above the editable continuity fields
- confirm the digest shows source anchor, source posture, continuity posture, value signal, latest touchpoint, and next-review framing without widening the workflow
- open the same loyalty record on the `History` tab and confirm a matching `History source-context digest` appears above the history-side outcome and packet fields
- confirm the History digest shows source anchor, source posture, continuity posture, latest outcome, latest packet, latest touchpoint, and next-review framing without switching tabs
- confirm the create screen now shows a right-side `Help & Glossary` panel instead of the old full-width glossary block
- confirm Backend -> `Mykonos Inquiries` -> `Inquiry Queue` shows a full-height right-side help rail that no longer shrinks the top navigation bar
- confirm the help rail now reserves space against the plugin content host instead of the whole page body
- confirm Backend -> `Mykonos Inquiries` -> `Loyalty Continuity` list also uses the same corrected right-side help rail behavior
- confirm the same right-side help rail appears on create mode plus Overview, Workspace, and History for saved loyalty records
- confirm the active plugin content surface leaves space for the help rail while the top navigation remains full-width
- confirm the Inquiry Queue loyalty card no longer includes an inline expandable glossary block
- confirm the Loyalty Continuity list source card no longer includes an inline expandable glossary block
- open backend → `Mykonos Inquiries`
- confirm the list shows `Loyalty Link`, `Loyalty Backlink`, `Loyalty Cue`, and `Loyalty Actions`
- confirm linked inquiries show the linked loyalty request reference and continuity posture directly on the queue row
- confirm linked inquiries now also show a compact `Queue-to-history cue` with the latest loyalty outcome, touchpoint/packet framing, and review timing directly on the queue row
- confirm linked inquiries now also show an always-visible `Packet` badge on the queue-side loyalty card
- confirm the queue-side packet badge shifts tone appropriately between no-packet, pending/watch, and prepared states
- confirm linked inquiries now also show an always-visible `Next review` pill beside the packet badge on the queue-side loyalty card
- confirm the queue-side next-review pill shifts appropriately between overdue, today, future-review, and no-review states
- confirm linked inquiries can use `Open loyalty` directly from the queue
- confirm linked inquiries can use `Open loyalty history` directly from the queue and land on the saved loyalty `History` tab
- confirm transfer-ready inquiries can use `Create + open loyalty` directly from the queue
- confirm prefill-ready inquiries can use `Open draft` directly from the queue
- confirm the new `Loyalty Posture` filter appears on the Inquiry Queue list
- confirm the queue can isolate linked, transfer-ready, draft-ready, and queue-only inquiries using that filter
- confirm the Queue overview now shows a compact loyalty-routing summary block with counts for linked, transfer-ready, draft-ready, queue-only, and workspace-staged workload
- confirm opening the `Loyalty Posture` filter popup no longer throws an error
- confirm the queue overview shows a compact loyalty-posture badge strip that mirrors the live filter buckets
- confirm Loyalty Continuity shows a first-record guidance panel when the live loyalty list is empty
- confirm the guidance panel points operators back to Inquiry Queue or manual draft creation as appropriate
- confirm the list workspace overview still shows `Linked to loyalty` and `Ready for loyalty`
- open an inquiry detail screen and use `Open prefilled loyalty draft`
- confirm request reference, guest basics, and summaries seed from the inquiry before first save
- use `Create + open loyalty` from the Inquiry Queue or inquiry detail screen
- confirm the loyalty update screen shows a bridge confirmation banner
- confirm the banner distinguishes `record created` versus `existing record reopened`
- confirm the banner explicitly says when the transfer created the first live loyalty record
- confirm the loyalty list now shows a `Source Inquiry` backlink strip on each row
- confirm linked loyalty rows can use `Open inquiry` directly from the list
- confirm linked loyalty rows can use `Back to queue search` directly from the list
- confirm the Loyalty Continuity list `Source Inquiry` card now shows compact `Latest outcome`, `Latest packet`, and `Next review` cue boxes without opening the record
- confirm the same loyalty list card now also shows an always-visible `Packet` badge near the top of the row card for faster scan reading
- confirm hovering those list-card labels shows tooltip help
- confirm linked loyalty rows now also show `Open loyalty history` directly on the list card
- click `Open loyalty history` and confirm the saved loyalty record opens on `#primarytab-history`
- `php scripts/qa-loyalty-workspace-activation.php`

- open Backend -> `Mykonos Inquiries` -> `Inquiry Queue` and confirm queue-side loyalty backlink cards still render
- hover key labels such as `Queue-to-history cue` and confirm tooltip text appears
- open `Loyalty Continuity` create or update screens and confirm the new right-side `Help & Glossary` panel appears
- open the right-side help panel glossary and confirm it explains source anchor, source posture, continuity posture, value signal, latest outcome, latest packet, next review, queue-to-history cue, and manual vs inquiry-backed drafts
- hover digest labels on Overview, Workspace, and History and confirm tooltip text appears without breaking render safety

Do **not** treat `plugin:refresh Cabnet.MykonosInquiry` as the default first production step for this line.
The sync migration was added specifically to avoid a destructive rebuild-first posture on a live inquiry plugin.

---

## Root continuity companion file
Keep both files updated together:
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

---

## Deployment requirement
Every deployment patch zip must preserve the rooted structure.

The user extracts from:
- `/home/cabnet/public_html/`

So patch zips must place files under:
- `mykonos.cabnet.app/...`
