# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow, Loyalty Continuity workspace, and operator-focused backend handling.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend Inquiry Queue
- Loyalty Continuity workspace
- Workspace Docs
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
- Loyalty Continuity routing and continuity transfers
- generated request reference shown after successful submit
- safe email notification handling
- operator workflow actions, notes, docs, and continuity improvements

## Current stable continuity hint

### v6.41.72 — Shared List Heading Polish
Included in the current stable operator workflow line:
- shared toolbar and helper-note layout hardening
- shared filter-row wrap and spacing polish
- shared filter label shortening
- shared list heading and first-visible column-label tightening

## Deployment philosophy

This project follows:
- inspect first, change second
- small production-safe patches
- preserve working routes and business continuity
- avoid schema drift unless clearly justified
- keep public theme flow stable
- improve operator workflow incrementally
- prefer plugin-only backend polish where possible
