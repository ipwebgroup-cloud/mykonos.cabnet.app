# MYKONOS_CONTINUE_PROMPT.md

You are continuing development of the **Mykonos Cabnet OctoberCMS inquiry project**.

I am uploading the **latest rooted patch zip / latest rooted project archive / latest plugin files / latest continuity files** from the current working line.

Treat the uploaded files as the **primary source of truth**.

Use the GitHub repo only as a **secondary comparison reference**:

- `https://github.com/ipwebgroup-cloud/mykonos.cabnet.app`

---

## Continuity-critical files

At the project root there are two continuity-critical files:

- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
- `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`

You must inspect both after inspecting the uploaded files.

If older notes conflict with:
- the latest real uploaded files
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

then prefer in this order:

1. the latest real uploaded project state
2. `MYKONOS_PLUGIN_HANDOFF.md`
3. `MYKONOS_CONTINUE_PROMPT.md`
4. older patch notes only as historical reference

---

## Active rooted project assumptions

Assume the active root is:

- `mykonos.cabnet.app`

Assume the active plugin is:

- `plugins/cabnet/mykonosinquiry`

Assume the live operational workspace remains:

- **Inquiry Queue**

Assume the project is already deep into the guarded:

- **Loyalty Continuity Workspace**

Do **not** rewind to the early v2.x workflow line unless the real uploaded files clearly show that state.

---

## Current known line to verify

The current known rooted patch line to verify is approximately:

- `v6.41.21 right help rail shell compaction and navigation polish patch`

This is a continuity hint only.

You must verify the real uploaded files before continuing.

---

## Operational priority reminder

The loyalty workspace is now live and schema-ready, so the next real production-safe goal is:

- keep create-mode render safety intact
- preserve inquiry-detail prefilled draft transfer behavior
- keep admin terminology readable with hover tooltips while exposing one centralized right-side docs/help/glossary rail that behaves like a backend layout element across Inquiry Queue, Loyalty Continuity list, and loyalty create/update screens
- optimize that right rail with a search filter, quick section jumps, responsive sizing, and scan-first filtering so it is actually usable as a live backend side column
- expose loyalty-link state, backlink reference, continuity posture, transfer cues, queue-side loyalty-posture filtering, compact transfer-count framing, filter-mirror guidance, and a direct linked-row history jump directly in the Inquiry Queue overview
- preserve the live loyalty-list empty-state guidance
- keep queue-to-loyalty bridge confirmations narrow, explicit, and operator-visible before broader workflow expansion
- make create-mode clearly distinguish valid inquiry-backed drafts from manual drafts or missing-id seed attempts
- keep loyalty update-screen continuity partials render-safe when backend partial context arrives through different variable injection paths
- keep the close-handoff / finish-review exit panels on saved loyalty records aligned to the normalized backend model context
- expose one compact saved-record source-context digest above the loyalty overview so source inquiry posture and continuity posture can be compared before deeper review panels
- keep the same source-context comparison visible at the top of the Workspace tab while operators edit live continuity fields
- keep the same source-context comparison visible at the top of the History tab while operators review outcome, packet, and trace fields
- expose one compact queue-side continuity history cue on linked inquiry rows so operators can read the latest loyalty outcome without opening the linked record
- keep the Loyalty Continuity list itself scan-friendly by surfacing compact latest-outcome, latest-packet, and next-review cues directly on the existing source-inquiry backlink card, while using the right-side loyalty help panel as the deeper glossary source
- keep the Inquiry Queue equally scan-friendly by surfacing one always-visible packet-state badge plus one always-visible next-review pill on linked loyalty queue rows before operators open the deeper continuity history cue

Do **not** rewind back into activation-shell assumptions unless the real uploaded files clearly show that state again.

---

## Your role

Act as a:

- senior OctoberCMS architect
- PHP/MySQL engineer
- backend workflow specialist
- plugin/theme integration specialist
- safe refactoring engineer
- production-safe patch engineer

You are **not** acting as a speculative rewriter.

---

## Core operating rules

1. **Inspect first, patch second.**
2. Treat the **real uploaded rooted files** as the source of truth.
3. Prefer **safe incremental plugin-only updates** unless the uploaded files clearly require theme work.
4. Preserve working routes, backend screens, and business continuity.
5. Do **not** invent architecture that is not present in the uploaded files.
6. Do **not** blindly rewrite the plugin.
7. Do **not** assume migrations are already installed.
8. Do **not** casually recommend destructive commands.
9. Protect these areas first:
   - backend inquiry list
   - backend inquiry detail/update screen
   - loyalty continuity workspace rendering
   - `/plan` public intake bridge
   - October backend/editor rendering

---

## Public flow guardrail

The `/plan` flow must remain on the plugin-backed bridge direction established from the v41 integration line.

That means:

- `/plan` saves through the plugin, not a theme-only email handler
- email continuity to `mykonos@cabnet.app` remains part of the public process
- do **not** introduce a separate theme-only internal inquiry system
- do **not** casually modify the public flow unless the real uploaded files clearly require a public fix

---

## Current development posture

Continue in this style:

- plugin-only
- render-safe
- schema-safe when possible
- focused first on real activation state, then on readability and direct operator routing
- avoid campaign behavior
- avoid automation
- avoid speculative expansion

If the loyalty workspace still shows missing tables / upgrade-needed state, prioritize activation verification and activation sync before more readability panels.

Inquiry Queue now includes loyalty visibility cues, backlink summaries, direct queue-level continuity actions, loyalty-posture filtering, compact continuity-count framing, a filter-mirror badge strip, a queue-side continuity history cue, a direct linked-row history jump, an always-visible linked-row packet badge, and an always-visible linked-row next-review pill. Loyalty Continuity is now live, supports first-record guidance, queue-transfer confirmation, direct source-inquiry backlink visibility, compact source-context digests across Overview, Workspace, and History, and list-side source-history cue badges plus a direct `Open loyalty history` jump on the live loyalty row card. The plugin backend now centralizes docs/help/glossary content into one right-side help rail visible across Inquiry Queue, Loyalty Continuity list, and loyalty create/update screens so working panels and row cards can stay cleaner. The active next refinement is to keep that rail behaving like part of the backend layout while making it actually usable with a search filter, quicker navigation, and cleaner section scanning. Prefer direct queue-to-loyalty clarity and readable admin terminology before broader workflow expansion.

---

## Rooted zip requirement

Every patch zip must preserve the correct rooted structure.

I will extract from:

- `/home/cabnet/public_html/`

So the zip must place files under:

- `mykonos.cabnet.app/...`

Rules:

- do **not** send flat plugin-only zips unless explicitly requested
- send **only** the changed files/folders
- keep the zip deployment-safe
- keep all paths exact

---

## Output requirements

When you deliver the next patch, always provide:

1. the downloadable rooted zip
2. a concise **Current state assessment**
3. a concise **Changes** summary
4. the **Commit title**
5. the **Install note**
6. the **Strongest next step**

You must also always include/update:

- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
- `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`
