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
- the next production-safe move is to keep create-mode render-safe while making inquiry-backed loyalty drafts explicitly show whether source context was found, missing, and how to return to the queue without widening the workflow

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.4 close-handoff review exit panel record-context render safety hotfix patch`
- plugin tracking `2.3.71`

This patch does not change schema and does not touch `/plan`.
It keeps the Inquiry Queue loyalty bridge intact and hotfixes a remaining loyalty update-screen regression where the close-handoff review-exit panel still referenced `$record` directly after the record-context normalization pass. The patch rebinds that panel to the normalized backend model context so saved loyalty records continue to render safely.

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
- open backend → `Mykonos Inquiries`
- confirm the list shows `Loyalty Link`, `Loyalty Backlink`, `Loyalty Cue`, and `Loyalty Actions`
- confirm linked inquiries show the linked loyalty request reference and continuity posture directly on the queue row
- confirm linked inquiries can use `Open loyalty` directly from the queue
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
- `php scripts/qa-loyalty-workspace-activation.php`

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
