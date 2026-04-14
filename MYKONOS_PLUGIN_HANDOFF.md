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
- guarded Loyalty Continuity Workspace
- Workspace Docs help surface
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
- **Loyalty Continuity Workspace**
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
- keep queue toolbar, helper-note, and filter wrapping stable on narrower widths

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.68 inquiry-queue filter wrap polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It keeps the Inquiry Queue toolbar and helper-note stable while also making the top filter row wrap more cleanly on narrower widths.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- toolbar buttons remain visible
- helper note stays on its own row and wraps normally
- search stays separate from helper copy
- top filter controls wrap cleanly instead of colliding or clipping

---

## Safest next step
If the Inquiry Queue still feels visually heavy after this patch, the next real pass should inspect:
- whether the filter row can use slightly tighter spacing and clearer grouping labels
- whether the queue summary note can shorten further without losing meaning
- whether any first-visible queue labels still mix older wording
- whether loyalty list and inquiry queue top rows now need one shared layout pattern

Keep future work plugin-only where possible.
