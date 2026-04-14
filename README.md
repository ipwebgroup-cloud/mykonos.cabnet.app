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
- loyalty continuity transfer, staging, and review surfaces
- dedicated Workspace Docs routing for help and glossary content

## Current safe continuity hint

### v6.41.66 — Inquiry Queue toolbar layout hotfix
Included in the current safe operator workflow line:
- queue toolbar wrap and spacing hardening
- search box collision prevention
- helper note width and overflow cleanup
- no public `/plan` change
- no schema change

## Plugin tracking baseline

### 2.4.23
Current continuity tracking remains aligned to the guarded loyalty-workspace line through:
- compact inquiry update header
- compact loyalty update header
- queue scan-speed and pagination work
- loyalty continuity workspace and docs-page posture

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
- `MYKONOS_PLUGIN_HANDOFF.md`
- `MYKONOS_CONTINUE_PROMPT.md`
