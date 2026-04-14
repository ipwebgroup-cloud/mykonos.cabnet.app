# Mykonos Cabnet OctoberCMS Inquiry Platform

Private project repository for the live **Mykonos Cabnet inquiry platform** built on **OctoberCMS**, with a plugin-backed luxury inquiry workflow and operator-focused backend handling.

## Project purpose

This repository tracks the production-safe source for:
- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed persistence through `Cabnet.MykonosInquiry`
- backend inquiry queue and operator workflow
- guarded loyalty continuity workspace
- dedicated workspace docs/help
- safe incremental plugin/theme integration

## Current active line

### Theme
- Active live theme directory: `themes/mykonos-aurelia-lux`

### Plugin
- Plugin: `plugins/cabnet/mykonosinquiry`
- Backend label: **Mykonos Inquiries**
- Public bridge component: `mykonosPlanBridge`

## Stable workflow direction

The working production line preserves:
- `/plan` submission through `mykonosPlanBridge::onSubmitInquiry`
- inquiry persistence into `cabnet_mykonos_inquiries`
- backend inquiry queue and detail handling
- loyalty continuity workspace handling
- generated request reference shown after successful submit
- safe email notification handling
- operator workflow actions, notes, docs, and continuity improvements

## Current stable continuity hint

### v6.41.70 — Shared list filter row consistency patch
Included in the current safe continuity line:
- stable wrapped queue toolbar
- helper-note isolation and normal wrapping
- shared list toolbar layout consistency
- shared list filter-row consistency for inquiry and loyalty lists
