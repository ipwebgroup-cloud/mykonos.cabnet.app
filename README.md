# Mykonos Cabnet OctoberCMS Inquiry Platform

This repository contains the live source for the **Mykonos Cabnet inquiry platform** built on OctoberCMS.

## Current direction

This project is no longer a theme-only luxury site experiment.
It is now a real inquiry workflow platform with:

- luxury public frontend
- mobile-first `/plan` inquiry flow
- DB-backed `Cabnet.MykonosInquiry` persistence
- backend inquiry queue and operator workflow
- safe theme / plugin integration
- safe incremental production-first changes

## Active lines

### Theme
- active theme directory: `themes/mykonos-aurelia-lux`
- public `/plan` is wired through the plugin bridge

### Plugin
- plugin: `plugins/cabnet/mykonosinquiry`
- backend menu: **Mykonos Inquiries**
- persistence table: `cabnet_mykonos_inquiries`
- notes/history table: `cabnet_mykonos_inquiry_notes`

## Current stable workflow line

The current stable operator workflow line includes:

- plugin-backed `/plan` persistence
- safe mail handling in the inquiry manager
- backend inquiry list stability hotfix baseline
- detail screen polish
- history timeline readability
- assignment / status continuity readability

## Version checkpoints

### v2.5.2
Backend inquiry update-screen polish:
- stronger inquiry header
- clearer operator summary
- tighter quick-action presentation

### v2.5.3
History timeline usability:
- card-based readable history timeline
- easier operator scanning of note type, author, time, and body

### v2.5.4
Assignment and status continuity:
- workflow continuity panel
- clearer owner, queue posture, next action, follow-up, and closure readability

## Safe working rules

- inspect first, change second
- prefer plugin-side operator improvements over theme drift
- avoid schema changes unless clearly justified
- keep public `/plan` stable
- keep backend list rendering conservative and reliable
- package work as small rooted patches whenever possible

## Local patch workflow

Recommended workflow for this repository:

1. keep a clean local working copy of `mykonos.cabnet.app`
2. extract rooted patch zips directly over the local repo root
3. review changes in GitHub Desktop
4. commit and push from GitHub Desktop
5. tag stable checkpoints after meaningful operator-facing improvements

## Important paths

- `plugins/cabnet/mykonosinquiry/classes/InquiryManager.php`
- `plugins/cabnet/mykonosinquiry/components/PlanBridge.php`
- `plugins/cabnet/mykonosinquiry/controllers/Inquiries.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/update.htm`
- `plugins/cabnet/mykonosinquiry/models/Inquiry.php`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `themes/mykonos-aurelia-lux/pages/plan.htm`
- `themes/mykonos-aurelia-lux/partials/plan/form.htm`

## Notes

This repo intentionally excludes:

- `.env`
- `auth.json`
- `vendor/`
- runtime storage contents
- SQL dumps
- zip artifacts
- server-local config such as `.user.ini` and `php.ini`
