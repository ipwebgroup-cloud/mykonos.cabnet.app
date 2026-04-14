# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow and operator-focused backend handling.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend inquiry queue and operator workflow
- guarded Loyalty Continuity Workspace
- dedicated Workspace Docs page
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
- backend Inquiry Queue and inquiry detail handling
- Loyalty Continuity rendering and transfer flow
- Workspace Docs routing for help/glossary content
- generated request reference shown after successful submit
- safe email notification handling
- operator workflow actions, notes, and continuity improvements

## Current safe continuity hint

### v6.41.64 — Detail Snapshot Wording Polish
Current safe line includes:
- `2.4.23` compact inquiry and loyalty update headers with collapsed guides
- queue-first scan-speed posture
- dedicated Workspace Docs help routing
- loyalty-aware queue and transfer flow
- detail-screen snapshot wording polish on the top read-only summary blocks

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
- keep future work plugin-only where possible

## Release documentation

See:
- `CHANGELOG.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`
