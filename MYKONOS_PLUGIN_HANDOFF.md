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
- the plugin has been carrying a centralized docs/help/glossary system for queue and loyalty terminology
- the Inquiry Queue toolbar has now been reduced to a minimal button-first layout so the live queue page avoids rendering the heavier inline workspace shell before the list appears
- the newest safe UX step is to keep the queue fast first, keep deeper guidance in the docs page, keep the row-count controls visually aligned and easy to use, keep safe queue view presets available so lower-value columns can be hidden during faster scan passes, keep the compact loyalty row cards, merge state-heavy row details into tighter summary columns, and only move into deeper list-controller or model-calculation work if the page still feels slow after these lighter rendering fixes

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.55 inquiry-queue compact state summary columns patch`
- plugin tracking `2.4.22`

This patch does not change schema and does not touch `/plan`.
It keeps the lighter Inquiry Queue toolbar, row controls, view presets, and compact loyalty row cards, and now merges status / priority / loyalty state plus owner / follow-up details into tighter queue summary columns so operators scan each row with less horizontal drift.

## Deployment note
For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

This queue-summary-column patch is backend-only. No schema change is introduced and no plugin refresh is required for this step.

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
- confirm Backend -> `Mykonos Inquiries` -> `Inquiry Queue` no longer shows the old right-side help rail
- confirm the Inquiry Queue toolbar `Queue docs` button opens the docs page at the `Queue docs` section
- confirm the Queue workspace-shell `Bridge docs` link opens the docs page at the `Queue-to-loyalty bridge` section
- confirm the Loyalty Continuity toolbar `Continuity docs` button opens the docs page at the `Loyalty continuity` section
- confirm inquiry create/update `Inquiry screen help` buttons open the docs page at the `Record screens` section
- confirm loyalty create/update `Loyalty screen help` buttons also open the docs page at the `Record screens` section
- confirm the landing section receives a visible target highlight without reintroducing a right-side rail
- confirm the queue toolbar now includes `Queue help`
- open that button and confirm the dedicated docs page loads
- confirm the docs page includes search, quick section jumps, queue guidance, loyalty guidance, and glossary terms
- confirm the backend side menu now includes `Workspace Docs`
- open Backend -> Mykonos Inquiries -> Workspace Docs and confirm the dedicated docs page loads directly from navigation
- open Backend -> Mykonos Inquiries -> New inquiry and confirm `Workspace docs & glossary` appears above the form
- open an existing inquiry record and confirm the simplified `Simple help for this page` button appears above the record without narrowing the screen
- open Backend -> `Mykonos Inquiries` -> `Loyalty Continuity` -> `New Loyalty Record` and confirm the page now shows a top `Loyalty screen help` button
- open an existing loyalty record such as `/admin/cabnet/mykonosinquiry/loyaltyrecords/update/3` and confirm the update page also shows the same `Loyalty screen help` button
- click the button from create/update and confirm the dedicated docs page opens without restoring an inline right-side rail
- confirm Backend -> `Mykonos Inquiries` -> `Loyalty Continuity` now shows `Continuity docs` and no longer renders the old right-side help rail on the list page
- confirm the Inquiry Queue loyalty card no longer includes an inline expandable glossary block
- confirm the Loyalty Continuity list source card no longer includes an inline expandable glossary block
- open backend → `Mykonos Inquiries`
- confirm the queue toolbar now shows `Queue view` presets for `Core scan`, `Extended`, and `Full`
- confirm the default saved mode opens in `Extended` until an operator changes it
- switch to `Core scan` and confirm lower-value columns such as email, source, loyalty backlink, loyalty cue, and closed/contacted timestamps hide cleanly without breaking row links or paging
- switch to `Full` and confirm all queue columns return
- confirm the list still shows `Loyalty Link`, `Loyalty Backlink`, `Loyalty Cue`, and `Loyalty Actions` in `Full` mode
- confirm linked queue rows now render a more compact queue-side loyalty card with a tighter reference/posture stack, slimmer packet/review pills, and a shorter `History` jump
- confirm the queue-side loyalty actions block now renders in a narrower two-button layout with a one-line hint instead of a taller multi-line card
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
- confirm the Inquiry Queue now opens with the lighter fast-start shell instead of the older heavy multi-board workspace block
- confirm opening the `Loyalty Posture` filter popup no longer throws an error
- confirm the queue still provides direct links to simple queue help, repeat-guest handoff help, and the repeat-guest list
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

- open Backend -> `Mykonos Inquiries` -> `Inquiry Queue` and confirm the lighter queue shell still renders and queue-side loyalty backlink cards still render
- hover key labels such as `Queue-to-history cue` and confirm tooltip text appears
- open `Loyalty Continuity` create or update screens and confirm the top `Workspace docs & glossary` button appears
- open the dedicated docs page and confirm it explains source anchor, source posture, continuity posture, value signal, latest outcome, latest packet, next review, queue-to-history cue, and manual vs inquiry-backed drafts
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


## Latest applied patch line
- `v6.41.55 inquiry-queue compact state summary columns patch`
- plugin version line: `2.4.21`
