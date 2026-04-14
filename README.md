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

## Live workflow direction

The working production line preserves:
- `/plan` submission through `mykonosPlanBridge::onSubmitInquiry`
- inquiry persistence into `cabnet_mykonos_inquiries`
- generated request reference shown after successful submit
- safe email notification handling to `mykonos@cabnet.app`
- backend **Inquiry Queue** handling
- backend **Loyalty Continuity** handling
- dedicated backend **Workspace Docs** guidance

## Current verified continuity baseline

### Plugin-tracked baseline
The current verified plugin line continues through:
- loyalty workspace activation and guarded create/update safety
- queue-to-loyalty transfer actions and backlink visibility
- dedicated docs/help page routing
- queue scan-speed and pagination improvements
- compact inquiry update header and collapsed guide
- compact loyalty continuity update header and collapsed guide

### Current safe continuity checkpoint
Use the current continuity files and plugin history as the active baseline:
- continuity hint: `v6.41.61 loyalty-detail compact header and collapsed guide patch`
- plugin tracking: `2.4.23`

## Stable workflow guardrails

The stable production direction is:
- keep `/plan` plugin-backed
- do not reintroduce a theme-only inquiry system
- keep the Inquiry Queue usable first
- keep docs/help on the dedicated Workspace Docs page
- keep the Loyalty Continuity workspace intact
- prefer safe plugin-only updates unless theme work is clearly required

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
- keep the public theme flow stable
- improve operator workflow incrementally
- treat the latest rooted uploaded project state as the source of truth

## Release / continuity documentation

Use these continuity-critical files first when continuing work:
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`

Older patch notes remain useful as history, but future continuation should follow the real uploaded project state and the current continuity files before relying on older release labels alone.
