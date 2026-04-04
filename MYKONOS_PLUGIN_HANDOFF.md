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
- the immediate value move shifted from render safety to queue-level loyalty visibility and safer transfer guidance
- the current real production-safe move is **Inquiry Queue loyalty transfer-count and result framing** so operators can see linked, transfer-ready, and draft-ready continuity workload before applying filters or opening individual rows

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.40.5 inquiry queue loyalty transfer-count and result framing patch`
- plugin tracking `2.3.62`

This patch does not change schema and does not touch `/plan`.
It adds a compact loyalty-routing summary block to the Inquiry Queue overview so operators can see linked, transfer-ready, draft-ready, and queue-only workload counts before applying the `Loyalty Posture` filter or opening individual rows.

---

## Deployment note
For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

Then verify:

- Backend -> Mykonos Inquiries -> Loyalty Continuity
- click `New Loyalty Record` and confirm create opens cleanly
- open backend → `Mykonos Inquiries`
- confirm the list shows `Loyalty Link`, `Loyalty Backlink`, `Loyalty Cue`, and `Loyalty Actions`
- confirm linked inquiries show the linked loyalty request reference and continuity posture directly on the queue row
- confirm linked inquiries can use `Open loyalty` directly from the queue
- confirm transfer-ready inquiries can use `Create + open loyalty` directly from the queue
- confirm prefill-ready inquiries can use `Open draft` directly from the queue
- confirm the new `Loyalty Posture` filter appears on the Inquiry Queue list
- confirm the queue can isolate linked, transfer-ready, draft-ready, and queue-only inquiries using that filter
- confirm the Queue overview now shows a compact loyalty-routing summary block with counts for linked, transfer-ready, draft-ready, queue-only, and workspace-staged workload
- confirm the list workspace overview still shows `Linked to loyalty` and `Ready for loyalty`
- open an inquiry detail screen and use `Open prefilled loyalty draft`
- confirm request reference, guest basics, and summaries seed from the inquiry before first save
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
