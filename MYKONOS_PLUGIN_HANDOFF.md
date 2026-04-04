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
- the loyalty workspace code line has advanced to `v6.39.0 / 2.3.53`
- the live server can still remain stuck on the activation-safe shell if the loyalty tables were never actually installed
- the next real production-safe move is **schema activation sync**, not another readability-only loyalty panel

---

## Latest applied patch line
Latest known rooted patch prepared for deployment:

- `v6.39.2 loyalty workspace activation verification helper patch`
- plugin tracking `2.3.54`

This helper patch does not advance the schema history beyond `2.3.54`.
It adds a direct CLI verification script so the real activation state can be checked on-server without relying only on the guarded backend shell.

This patch restores the historically referenced migration files:
- `create_loyalty_records_table.php`
- `create_loyalty_touchpoints_table.php`
- `upgrade_loyalty_records_table_for_workspace_activation.php`
- `upgrade_loyalty_touchpoints_table_for_workspace_activation.php`

It also adds the forward-only recovery migration:
- `ensure_loyalty_workspace_activation_schema.php`

That extra recovery migration exists because a live installation can already be marked past `2.3.0` to `2.3.3` in version history while still missing the real loyalty tables/columns.

---

## Deployment note
For this patch, the first intended verification step is:

- `php scripts/qa-loyalty-workspace-activation.php`

If storage is still not ready, then run:

- `php artisan october:up`
- or `php artisan october:migrate` if that is what the install exposes

Then run:

- `php artisan cache:clear`
- `php scripts/qa-loyalty-workspace-activation.php`

Do **not** treat `plugin:refresh Cabnet.MykonosInquiry` as the default first production step for this line.
The sync migration was added specifically to avoid a destructive rebuild-first posture on a live inquiry plugin.

---

## Root continuity companion file
Keep both files updated together:
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

---

## Deployment requirement
Every deployment patch zip must preserve the rooted structure.

The user extracts from:
- `/home/cabnet/public_html/`

So patch zips must place files under:
- `mykonos.cabnet.app/...`
