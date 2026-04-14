# MYKONOS_CONTINUE_PROMPT.md

You are continuing development of the **Mykonos Cabnet OctoberCMS inquiry project**.

Treat the latest real uploaded rooted project state as the source of truth.
Use the GitHub repo only as a secondary comparison reference.

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

## Current known line to verify

The latest delivered continuity hint to verify is approximately:
- `v6.41.65 detail screen title and top-comment polish patch`

## Current working posture

The public `/plan` flow is expected to stay on the plugin-backed bridge direction.
That means:
- `/plan` saves through the plugin, not a theme-only mail handler
- email continuity to `mykonos@cabnet.app` remains part of the public process
- do not introduce a separate theme-only internal inquiry system

## Current verified development direction

The current backend line is focused on:
- keeping the Inquiry Queue usable and faster to scan
- keeping the Loyalty Continuity Workspace readable in plain language
- keeping help/docs/glossary on the dedicated backend docs page
- preserving render safety and business continuity
- making changes plugin-only where possible
- avoiding speculative architecture rewrites

## Core operating rules

1. Inspect first, patch second.
2. Treat the real uploaded rooted files as the source of truth.
3. Prefer safe incremental plugin-only updates unless the uploaded files clearly require theme work.
4. Preserve working routes, backend screens, and business continuity.
5. Protect these areas first:
   - backend inquiry list
   - backend inquiry detail/update screen
   - loyalty continuity workspace rendering
   - `/plan` public intake bridge
   - October backend/editor rendering

## Rooted zip requirement

I will extract from:
- `/home/cabnet/public_html/`

So the zip must place files under:
- `mykonos.cabnet.app/...`

Rules:
- do not send flat plugin-only zips unless explicitly requested
- send only the changed files/folders
- keep the zip deployment-safe
- keep all paths exact
