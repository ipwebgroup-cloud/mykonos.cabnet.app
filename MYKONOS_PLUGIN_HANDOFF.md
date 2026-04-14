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
3. inspect `MYKONOS_CONTINUE_PROMPT.md` third
4. use the GitHub repo only as a secondary comparison reference
5. if older notes conflict with the real uploaded files, prefer the real uploaded files

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
- backend Inquiry Queue and operator workflow
- guarded Loyalty Continuity workspace
- dedicated Workspace Docs route
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
- **Loyalty Continuity**
- **Workspace Docs**

Preserve first:
- backend inquiry list
- backend inquiry update/detail screen
- loyalty continuity workspace rendering
- `/plan` public bridge
- October backend/editor rendering

---

## Current development line
The project is deep into the guarded loyalty-workspace line.

Current safe priorities:
- keep the Inquiry Queue fast first
- keep docs/help on the dedicated docs page instead of re-expanding live screens
- keep operator wording plain and readable
- keep loyalty transfer / backlink visibility stable
- keep row-level scan speed improving through smaller, clearer queue summaries
- keep top-of-screen record summaries compact and easy to read

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.63 detail-screen snapshot wording polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It lightly refines small read-only summary surfaces so Inquiry Queue and Loyalty Continuity record screens use simpler top-of-screen wording without changing the deeper workspace panels.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue toolbar uses Loyalty wording consistently
- Backend -> Inquiry Queue -> open any inquiry and confirm the top summary reads more plainly
- Backend -> Loyalty Continuity -> open any saved record and confirm the top digest reads more plainly
- deeper workflow tabs and actions still render normally

---

## Safest next step
If the record screens still feel heavy after this patch, the next real pass should inspect:
- whether the inquiry update page title and loyalty update page title should be tightened further
- whether top-level field comments on the two record screens can be shortened safely
- whether any remaining mixed wording between "continuity", "loyalty", and "repeat guest" should be normalized on read-only labels
- whether additional always-visible helper copy should move fully into the docs page

Keep future work plugin-only where possible.
