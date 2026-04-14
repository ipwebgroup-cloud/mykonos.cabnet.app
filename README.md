# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow and operator-focused backend handling.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend inquiry queue and operator workflow
- guarded loyalty continuity workspace
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
- backend inquiry list and detail handling
- generated request reference shown after successful submit
- safe email notification handling
- operator workflow actions, notes, and continuity improvements
- loyalty continuity handling and queue-to-loyalty transfer tools
- dedicated Workspace Docs routing for heavier operator guidance

## Current stable continuity hint

### v6.41.73 — Loyalty List Default Visibility Polish
Included in the current safe backend line:
- shared toolbar layout consistency
- shared filter row consistency
- shared filter label shortening
- shared list heading polish
- loyalty list default visibility polish

Plugin tracking remains on the safe continuity baseline:
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

## Release documentation

See:
- `CHANGELOG.md`
- continuity files at project root
- patch note files delivered with each rooted patch zip
