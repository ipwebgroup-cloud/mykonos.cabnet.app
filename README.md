# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow, an operator-focused queue, and a guarded loyalty continuity workspace.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend Inquiry Queue and operator workflow
- guarded Loyalty Continuity workspace
- dedicated Workspace Docs route
- safe incremental plugin/theme integration

## Current active line

### Theme
- Active live theme directory: `themes/mykonos-aurelia-lux`
- Branding/content line: **Mykonos Nocturne Luxe**

### Plugin
- Plugin: `plugins/cabnet/mykonosinquiry`
- Public bridge component: `mykonosPlanBridge`

### Backend workspaces
- **Inquiry Queue**
- **Loyalty Continuity**
- **Workspace Docs**

## Stable workflow direction

The working production line preserves:
- `/plan` submission through `mykonosPlanBridge::onSubmitInquiry`
- inquiry persistence into `cabnet_mykonos_inquiries`
- backend inquiry list and detail handling
- loyalty continuity rendering and inquiry-backed transfer support
- generated request reference shown after successful submit
- safe email notification handling
- compact record headers and collapsed plain-language guides
- queue-first operator workflow improvements

## Current safe continuity hint

### v6.41.63 — Detail-Screen Snapshot Wording Polish
Included in the current safe line:
- continuity alignment through `v6.41.62`
- queue and loyalty toolbar wording consistency
- lighter top-of-screen wording on inquiry and loyalty read-only summary blocks

### Plugin tracking baseline
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
- prefer plugin-only backend work where possible

## Release documentation

See:
- `CHANGELOG.md`
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`
