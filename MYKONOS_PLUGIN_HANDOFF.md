# MYKONOS_PLUGIN_HANDOFF.md

## Project
Mykonos Cabnet OctoberCMS inquiry project

## Active root
- `mykonos.cabnet.app`

## Active plugin
- `plugins/cabnet/mykonosinquiry`

## Core operating rule
Treat the latest real uploaded rooted project state as the source of truth.

## Stable project direction
- public luxury frontend
- mobile-first `/plan` inquiry flow
- DB-backed inquiry persistence through the plugin
- backend inquiry queue and operator workflow
- guarded Loyalty Continuity Workspace
- Workspace Docs
- safe incremental development without breaking live operations

## Current verified safe hint
- `v6.41.70 shared list filter row consistency patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.

## Deployment note
Upload the rooted files and then run:
- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

## Safest next step
After this patch, keep the next pass plugin-only and inspect whether the first visible queue and loyalty filter labels should be shortened slightly for faster scan reading.
