# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow and operator-focused backend handling.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend inquiry queue and operator workflow
- loyalty continuity workspace
- safe incremental plugin/theme integration

## Current active line

### Theme
- Active live theme directory: `themes/mykonos-aurelia-lux`
- Branding/content line: **Mykonos Nocturne Luxe**

### Plugin
- Plugin: `plugins/cabnet/mykonosinquiry`
- Backend label: **Mykonos Inquiries**
- Public bridge component: `mykonosPlanBridge`

## Current stable continuity hint

### v6.41.65 — Detail screen title and top-comment polish
Included in the current stable backend polish line:
- compact inquiry header and collapsed guide direction preserved
- compact loyalty header and collapsed guide direction preserved
- queue and loyalty wording consistency preserved
- record titles and first-seen field comments tightened for faster scan reading

## Stable workflow direction

The working production line preserves:
- `/plan` submission through `mykonosPlanBridge::onSubmitInquiry`
- inquiry persistence into `cabnet_mykonos_inquiries`
- backend inquiry list and detail handling
- loyalty continuity workspace handling
- dedicated Workspace Docs route
- generated request reference shown after successful submit
- safe email notification handling

## Deployment philosophy

This project follows:
- inspect first, change second
- small production-safe patches
- preserve working routes and business continuity
- avoid schema drift unless clearly justified
- keep public theme flow stable
- improve operator workflow incrementally
- prefer plugin-only updates where possible
