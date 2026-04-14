# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow, operator-focused backend handling, and a guarded loyalty continuity workspace.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend Inquiry Queue and operator workflow
- Loyalty Continuity workspace
- Workspace Docs / help routing
- safe incremental plugin/theme integration

## Current active line

### Theme
- Active live theme directory: `themes/mykonos-aurelia-lux`
- Branding/content line: **Mykonos Nocturne Luxe**

### Plugin
- Plugin: `plugins/cabnet/mykonosinquiry`
- Backend navigation:
  - **Inquiry Queue**
  - **Loyalty Continuity**
  - **Workspace Docs**
- Public bridge component: `mykonosPlanBridge`

## Stable workflow direction

The working production line preserves:
- `/plan` submission through `mykonosPlanBridge::onSubmitInquiry`
- inquiry persistence into `cabnet_mykonos_inquiries`
- backend inquiry list and detail handling
- generated request reference shown after successful submit
- safe email notification handling
- operator workflow actions, notes, and continuity improvements
- loyalty transfer, backlink, and continuity record handling
- queue-first scan-speed and compact record-screen posture

## Current safe continuity checkpoint

### Backend continuity line
Current verified safe continuity direction includes:
- Inquiry Queue pagination / leaner default load
- dedicated Workspace Docs page
- compact inquiry update header
- compact loyalty update header
- collapsed plain-language guides
- plugin tracking aligned to the latest verified continuity hint: **2.4.23**

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
- continuity files at project root
- patch note files delivered with each rooted patch zip
