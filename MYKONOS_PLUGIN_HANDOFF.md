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
- dedicated Workspace Docs page
- safe plugin/theme integration
- safe incremental development without breaking live operations

---

## Public flow guardrail
The `/plan` flow must remain on the plugin-backed bridge direction.

That means:
- `/plan` saves through the plugin, not a theme-only email handler
- email continuity to `mykonos@cabnet.app` remains part of the public process
- do **not** introduce a separate theme-only internal inquiry system

---

## Current verified line
The project is deep into the guarded loyalty-workspace line.

Current safe priorities:
- keep the Inquiry Queue fast first
- keep docs/help on the dedicated docs page
- keep operator wording plain and readable
- keep loyalty transfer / backlink visibility stable
- keep row-level scan speed improving through smaller, clearer queue summaries

## Latest applied patch line
Latest safe rooted patch prepared for deployment:

- `v6.41.67 inquiry queue helper-note wrapping hotfix`
- plugin tracking `2.4.23`

This patch is backend-only and does not touch `/plan`.
It keeps the queue toolbar readable by forcing the helper note onto its own full-width row and allowing the note copy to wrap normally instead of colliding with the search area.

## Deployment note
Upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

## Verify
- Backend -> Inquiry Queue
- the helper note sits on its own line
- the note text wraps normally
- the search box no longer collides with the helper note
- queue filters and records still render normally

## Safest next step
After this hotfix, the next real pass should inspect:
- whether the filter row needs spacing/wrapping polish on narrower widths
- whether any remaining first-row queue toolbar text can be shortened further
- whether the queue search and setup controls should align more tightly without crowding

Keep future work plugin-only where possible.
