# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow, guarded loyalty continuity workspace, and operator-focused backend handling.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend Inquiry Queue and operator workflow
- guarded Loyalty Continuity workspace
- dedicated Workspace Docs/help route
- safe incremental plugin/theme integration

## Current active line

### Theme
- Active live theme directory: `themes/mykonos-aurelia-lux`
- Branding/content line: **Mykonos Nocturne Luxe**

### Plugin
- Plugin: `plugins/cabnet/mykonosinquiry`
- Backend label: **Mykonos Inquiries**
- Public bridge component: `mykonosPlanBridge`

## Stable workflow direction

The working production line preserves:
- `/plan` submission through `mykonosPlanBridge::onSubmitInquiry`
- inquiry persistence into `cabnet_mykonos_inquiries`
- backend inquiry queue and detail handling
- loyalty continuity workspace handling and queue transfer actions
- generated request reference shown after successful submit
- safe email notification handling
- compact backend list/detail layouts with scan-first defaults

## Current safe continuity hint

### v6.41.74 — Inquiry Queue default visibility polish
Included in the current safe backend polish line:
- shared list toolbar layout consistency
- shared filter-row consistency
- shared filter-label shortening
- shared list heading polish
- loyalty list default visibility polish
- inquiry queue default visibility polish

### Current plugin-tracked baseline
- `2.4.23`

## Repository rules

### Commit
Commit source code and documentation for:
- `app/`
- `bootstrap/`
- `config/`
- `modules/`
- `plugins/`
- `themes/`
- `tests/`
- root project files such as `artisan`, `composer.json`, `composer.lock`, `.htaccess`

### Do not commit
Do not commit live/server-local artifacts such as:
- `.env`
- `auth.json`
- `vendor/`
- `node_modules/`
- runtime `storage` contents
- `php.ini`
- `.user.ini`
- SQL dumps
- zip exports
- cPanel-local files

## Deployment philosophy

This project follows:
- inspect first, change second
- small production-safe patches
- preserve working routes and business continuity
- avoid schema drift unless clearly justified
- keep public theme flow stable
- improve operator workflow incrementally
- prefer plugin-only backend polish where possible

## Release documentation

See:
- `CHANGELOG.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`
