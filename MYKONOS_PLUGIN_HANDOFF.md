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
The project has progressed far beyond the early v2.x operator/concierge patches.

The current long-running line is the guarded:

- **Loyalty Continuity Workspace**

This line has been developed in staged, render-safe, production-safe increments.

Important realities:
- earlier backend failures were caused by missing partials or missing tables
- render safety matters more than feature ambition
- the loyalty workspace must not break if staged assets are missing
- Inquiry Queue must remain stable as the live operator system
- this line should remain plugin-only unless the real files clearly require theme work
- avoid turning this into automation or campaign logic

---

## Latest applied patch line
Latest known applied rooted patch line:

- `v6.31.0 queue-scan prioritization cues and human review timing clarity workspace`

This means the current workspace already includes the earlier conservative loyalty readability layers, including:
- finish-watch / reopen cues
- finish-close compression
- close handoff grouping
- finish review exit
- finish-lane handback
- post-close hold framing
- hold-release visibility
- quiet-lane return visibility
- hold-aging readability
- quiet-return timing
- hold-aging compression
- quiet-lane re-entry readiness
- hold-expiry grouping
- quiet-lane re-entry ordering
- hold-expiry compression
- quiet-lane cadence framing
- cadence compression
- quiet-lane resurfacing priority
- resurfacing compression
- quiet-lane review-slot framing
- review-slot compression
- quiet-lane resurfacing cadence grouping
- checkpoint ordering
- quiet-lane scan-pair compression
- owner-first checkpoint pairing
- quiet-lane return scan compression
- same-day checkpoint compression
- owner-visible quiet-lane return handback framing
- owner-confirmed same-day handback cueing
- quiet-lane return checkpoint polish
- owner-held return checkpoint compression
- same-day quiet-lane acknowledgement polish
- owner-visible same-day acknowledgement compression
- quiet-lane return confirmation framing
- owner-tagged return confirmation compression
- same-day quiet-lane acceptance framing
- owner-held quiet-lane acceptance compression
- tagged return checkpoint framing
- owner-tagged acceptance checkpoint compression
- quiet-lane return handoff framing
- owner-visible acceptance handoff compression
- quiet-lane return checkpoint alignment
- owner-aligned return checkpoint compression
- same-day acceptance handoff framing
- return checkpoint handoff compression
- owner-visible same-day acceptance alignment
- acceptance alignment compression
- quiet-lane return handoff confirmation
- acceptance confirmation compression
- quiet-lane return checkpoint confirmation
- acceptance confirmation handoff compression
- quiet-lane return checkpoint framing
- queue-scan prioritization cues
- human review timing clarity

Do **not** assume names alone are enough.
Confirm the actual uploaded files before continuing.

---

## Important continuity note
During the last continuation cycle, the rooted `.rar` archive was not reliably readable in the environment, so the working line was reconstructed from:
- the rooted project state available in the environment
- the repo comparison
- the rooted patch line that had already been produced

Because of that:
- always re-inspect the newly uploaded real rooted archive in the next chat
- if the uploaded real files differ from this handoff, prefer the real files
- if this handoff matches the real files, continue forward from this line

---

## Render-safety note
A real render-safety issue was found and fixed in the current line:
- `fields.yaml` referenced `_finish_handback_post_close_hold_panel.htm`
- that partial was missing in the current working tree
- it was restored in the `v6.10.0` line

This reinforces the main guardrail:
- inspect YAML partial references carefully
- prefer surgical render-safe fixes over ambitious changes

---

## Root continuity companion file
There is now also a reusable new-chat continuity prompt file at the project root:

- `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`

From this point forward, both files should be maintained together:
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

---

## Deployment requirement
Every deployment patch zip must preserve the rooted structure.

The user extracts from:
- `/home/cabnet/public_html/`

So patch zips must place files under:
- `mykonos.cabnet.app/...`

Rules:
- do **not** send flat plugin-only zips unless explicitly requested
- send only changed files/folders
- keep the zip deployment-safe
- keep all paths exact

---

## Install rules
If a patch is plugin-only and adds no schema or migrations:
- do **not** require `php artisan plugin:refresh Cabnet.MykonosInquiry`
- cache clear only if needed for stale backend output

If a patch adds migrations or schema alignment:
- explicitly state that `php artisan plugin:refresh Cabnet.MykonosInquiry` is required
- explicitly explain why it is required

Do **not** casually recommend destructive refresh/rebuild commands.

---

## Required working style in new chat
The assistant must behave like a:
- senior OctoberCMS architect
- PHP/MySQL engineer
- backend workflow specialist
- plugin/theme integration specialist
- safe refactoring engineer
- production-safe patch engineer

The assistant must:
1. inspect first
2. patch second
3. use the real uploaded files as source of truth
4. prefer safe incremental plugin-only changes
5. preserve routes, rendering, and business continuity
6. avoid speculative rewrites
7. avoid drifting into redesign
8. avoid framework swapping
9. avoid public theme rewrites unless clearly necessary

---

## Safest next development direction
The current safest likely next step is still within the same conservative plugin-only loyalty readability lane.

Strongest next direction:
- continue plugin-only
- continue render-safe
- continue schema-safe when possible
- improve acceptance checkpoint handoff compression
- improve quiet-lane return confirmation framing
- improve human prioritization cues
- avoid automation
- avoid public flow changes
- avoid theme drift

A likely next safe patch direction after `v6.29.0` is:

- **acceptance checkpoint handoff compression and quiet-lane return confirmation framing**

But this must be confirmed against the real uploaded files first.

---

## What the next chat should do first
Before making changes, the assistant must:

1. inspect the uploaded files in full
2. inspect `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
3. inspect `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`
4. identify the actual current plugin state
5. determine what is already implemented vs staged vs guarded
6. produce a concise current state assessment
7. recommend the strongest next safe implementation step
8. only then implement from the real uploaded state

---

## Output requirements for the next patch
When delivering the next patch, always provide:

1. the downloadable rooted zip
2. concise current state assessment
3. concise changes summary
4. commit title
5. install note
6. strongest next step

And always update:
- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
- `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`

---

## Commit continuity
Latest known commit-style patch title:
- `v6.27.0 return checkpoint handoff compression and owner-visible same-day acceptance alignment workspace`

Next patch naming should continue from the real uploaded state, not from memory alone.

---

## Final continuity reminder
If the user says **continue**:
- proceed from the latest real uploaded state
- do not restart the project
- do not drift
- do not reinvent the architecture
- do not rewind to older patch notes
- inspect first, then continue