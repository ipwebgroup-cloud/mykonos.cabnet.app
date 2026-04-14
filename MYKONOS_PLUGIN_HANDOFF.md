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

---

## Core operating rule
Treat the latest real uploaded rooted project state as the source of truth.

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
- keep default visible list columns focused on the strongest scan columns while leaving denser diagnostics available in List Setup

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.41.73 loyalty list default visibility polish patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It keeps the strongest loyalty scan columns visible by default and moves denser diagnostics back into List Setup so the live list stays more readable.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Loyalty Continuity
- the default visible columns are lighter and easier to scan
- the denser finish / queue diagnostic columns remain available in List Setup
- Inquiry Queue and `/plan` still behave normally

---

## Safest next step
If the list still feels visually heavy after this patch, the next real pass should inspect:
- whether the default visible loyalty list columns can compress further without losing essential context
- whether Inquiry Queue and Loyalty Continuity should share one clearer column-selection philosophy
- whether one or two top-value derived columns should replace several weaker visible diagnostics
- whether any remaining queue/list helper copy should move fully into the docs page
