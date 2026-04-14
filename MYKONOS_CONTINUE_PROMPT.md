# MYKONOS_CONTINUE_PROMPT.md

You are continuing development of the **Mykonos Cabnet OctoberCMS inquiry project**.

Treat the uploaded files as the **primary source of truth**.

Use the GitHub repo only as a **secondary comparison reference**.

## Continuity-critical files

At the project root there are two continuity-critical files:

- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
- `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`

Prefer in this order:
1. the latest real uploaded project state
2. `MYKONOS_PLUGIN_HANDOFF.md`
3. `MYKONOS_CONTINUE_PROMPT.md`
4. older patch notes only as historical reference

## Active rooted project assumptions

Assume the active root is:
- `mykonos.cabnet.app`

Assume the active plugin is:
- `plugins/cabnet/mykonosinquiry`

Assume the live operational workspace remains:
- **Inquiry Queue**
- **Loyalty Continuity Workspace**
- **Workspace Docs**

Do **not** rewind to the early v2.x workflow line unless the real uploaded files clearly show that state.

## Current known line to verify

The latest delivered continuity hint to verify is approximately:
- `v6.41.73 loyalty list default visibility polish patch`

This is a continuity hint only.
You must verify the real uploaded files before continuing.

## Current working posture

The project is already well beyond the original inquiry-plugin activation phase.

The public `/plan` flow is expected to stay on the **plugin-backed bridge direction** established from the v41 integration line.

## Current verified development direction

The current backend line is focused on:
- keeping the Inquiry Queue usable and faster to scan
- keeping the Loyalty Continuity Workspace readable in plain language
- keeping help/docs/glossary on the dedicated backend docs page
- preserving render safety and business continuity
- making changes plugin-only where possible
- avoiding speculative architecture rewrites
- keeping default visible list columns focused on the strongest scan columns while leaving denser diagnostics available in List Setup

## Important backend state to preserve

### 1. Dedicated docs/help page exists
Keep this direction.

### 2. Plain-language direction is active
Continue preferring:
- simple labels
- operator-friendly text
- less internal jargon
- less visual clutter

### 3. Inquiry Queue scan speed remains the latest priority
Keep the queue usable first.

### 4. Loyalty workspace remains active and should stay intact
Keep these safe:
- create-mode render safety
- inquiry-backed loyalty draft prefill behavior
- source inquiry backlink / context digest behavior
- saved loyalty record workflow
- plain-language helper blocks on loyalty screens
- lighter default visible columns with deeper diagnostics still available in List Setup

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
