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

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.59 inquiry-queue slimmer default first-load column set patch`
- plugin tracking `2.4.22`

This patch stays backend-only and does not touch `/plan`.
It keeps the server-side queue pagination line in place, but makes the default first queue load visibly leaner by hiding lower-priority columns until an operator explicitly enables them in List Setup.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Mykonos Inquiries -> Inquiry Queue
- linked rows still show loyalty backlink, packet, review, and action buttons
- the list still pages server-side instead of rendering the whole queue at once
- the first queue load now starts with a slimmer default visible column set
- List Setup can still restore Email, Source, Repeat-guest Backlink, Last Contacted, Closed, and Created
- no visible queue workflow regression appears after the default-column slimming change

---

## Safest next step
If the queue still feels heavy after this patch, the next real pass should inspect:
- whether the update/detail screen now becomes the next clearer render-weight target
- whether repeat-guest backlink and action row partials should collapse further on smaller screens
- whether any remaining queue-specific helper text should move fully into the docs page
- whether the loyalty workspace list should receive the same first-load slimming discipline

Keep future work plugin-only where possible.
