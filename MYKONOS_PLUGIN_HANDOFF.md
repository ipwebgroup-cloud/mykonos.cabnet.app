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
Do **not** rewind to older inquiry-only assumptions unless the uploaded files clearly show that state.
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
- dedicated Workspace Docs page
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

## Current verified development line
The project is deep into the guarded loyalty-workspace line.

Verified baseline from the plugin history and continuity files:
- queue-to-loyalty transfer actions are active
- loyalty backlink and posture visibility are active
- the dedicated docs/help page is active
- server-side Inquiry Queue pagination is active
- the inquiry update screen uses a compact header and collapsed guide
- the loyalty continuity update screen uses a compact header and collapsed guide

Current continuity hint to preserve:
- `v6.41.61 loyalty-detail compact header and collapsed guide patch`
- plugin tracking `2.4.23`

---

## Safe priorities now
- keep the Inquiry Queue fast first
- keep docs/help on the dedicated docs page instead of re-expanding live screens
- keep operator wording plain and readable
- keep loyalty transfer / backlink visibility stable
- keep row-level scan speed improving through smaller, clearer queue summaries
- prefer plugin-only updates where possible

---

## Deployment note
For the current continuity-alignment patch:
- no schema change is introduced
- no plugin refresh is required
- no cache clear is strictly required, though `php artisan cache:clear` is safe after deployment if documentation routing labels appear stale

---

## Safest next step
After this continuity alignment, the next real pass should inspect:
- whether inquiry and loyalty detail screens still contain any overly large always-visible helper copy
- whether dense read-only guidance blocks should group more tightly by tab
- whether queue / loyalty / docs wording should standardize around one operator language set
- whether any remaining helper text should move fully into the docs page

Keep future work plugin-only where possible.
