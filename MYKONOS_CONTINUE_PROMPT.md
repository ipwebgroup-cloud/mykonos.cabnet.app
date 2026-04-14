# MYKONOS_CONTINUE_PROMPT.md

You are continuing development of the **Mykonos Cabnet OctoberCMS inquiry project**.

I am uploading the **latest rooted patch zip / latest rooted project archive / latest continuity files** from the current working line.

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

prefer in this order:

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
- **Loyalty Continuity**
- **Workspace Docs**

Do **not** rewind to the early v2.x workflow line unless the real uploaded files clearly show that state.

---

## Current known line to verify

The latest delivered continuity hint to verify is approximately:

- `v6.41.63 detail-screen snapshot wording polish patch`

This is a continuity hint only.
You must verify the real uploaded files before continuing.

---

## Current working posture

The project is already well beyond the original inquiry-plugin activation phase.

The public `/plan` flow is expected to stay on the **plugin-backed bridge direction** established from the v41 integration line.

That means:
- `/plan` saves through the plugin, not a theme-only mail handler
- email continuity to `mykonos@cabnet.app` remains part of the public process
- do **not** introduce a separate theme-only internal inquiry system
- do **not** casually modify the public flow unless the real uploaded files clearly require a public fix

---

## Current verified development direction

The current backend line is focused on:
- keeping the Inquiry Queue usable and faster to scan
- keeping the Loyalty Continuity Workspace readable in plain language
- keeping help/docs/glossary on the dedicated backend docs page
- preserving render safety and business continuity
- making changes plugin-only where possible
- avoiding speculative architecture rewrites

---

## Important backend state to preserve

### 1. Dedicated docs/help page exists
The older side help rail has been replaced by a dedicated backend docs/help page.
Keep this direction.

### 2. Plain-language direction is active
Continue preferring:
- simple labels
- operator-friendly text
- less internal jargon
- less visual clutter

### 3. Inquiry Queue scan speed remains the latest priority
Recent safe work has already established:
- a lighter button-first toolbar
- queue-side scan-speed improvements remain in place
- the inquiry update screen now opens with a compact record summary instead of two large top advisory blocks
- the loyalty continuity update screen now follows the same compact-header and collapsed-guide direction
- the plain-language screen guides now stay collapsed by default and only open when needed
- queue and loyalty toolbar wording now use loyalty language more consistently
- the small read-only summary blocks at the top of record screens are being simplified before touching deeper workspace panels

Keep the queue usable first.
Do **not** expand the top area again with large advisory panels unless clearly requested.

### 4. Loyalty workspace remains active and should stay intact
Keep these safe:
- create-mode render safety
- inquiry-backed loyalty draft prefill behavior
- source inquiry backlink / context digest behavior
- saved loyalty record workflow
- plain-language helper blocks on loyalty screens

---

## Most recent safe next step

The strongest next step after the last delivered patch is:
- keep both inquiry and loyalty update screens compact and readable
- continue reducing always-visible helper copy before adding more UI chrome
- inspect whether top-level field comments can be shortened safely
- inspect whether page titles can be tightened without losing clarity
- keep operator language simple

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

## Output requirements for the next chat

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
