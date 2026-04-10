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
- the Inquiry Queue toolbar now supports button-first queue view presets plus row-count controls so operators can hide lower-value columns without changing the workflow
- the newest safe UX step is to keep the queue fast first, keep deeper guidance in the docs page, and collapse status / priority / owner / follow-up reading into tighter summary columns before moving into deeper list-controller work

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.54 inquiry-queue compact state summary columns patch`
- plugin tracking `2.4.21`

This patch stays backend-only and does not touch `/plan`.
It keeps the lighter Inquiry Queue toolbar, adds queue-view presets for faster scanning, and merges state-heavy row details into tighter queue summary columns so operators can read more inquiries without widening the screen.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:

- Backend -> Mykonos Inquiries -> Inquiry Queue
- confirm `Queue view` shows `Core scan`, `Extended`, and `Full`
- confirm `Extended` loads by default
- confirm `Queue State` now combines status, priority, and repeat-guest link posture
- confirm `Owner / Follow Up` now combines owner visibility and the next queue checkpoint posture
- confirm `Repeat-guest Backlink` and `Repeat-guest Actions` still work normally
- confirm filters, pager, and record links still work normally
