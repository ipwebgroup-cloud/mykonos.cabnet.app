# Mykonos Inquiry Plugin v2.3.4 Loyalty Operator Guardrails Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.4-loyalty-operator-guardrails-public-html-rooted.zip`

## What changed
- hardened both inquiry-side loyalty partials so they remain safe when Loyalty Continuity is only partially installed
- removed the fragile partial-level import pattern that caused the recent backend errors
- added clearer readiness messaging on the inquiry detail screen
- added operator guidance so loyalty handoff is framed as a post-triage retention step instead of something mixed into the active queue too early
- snapshot panel now shows a fuller continuity summary when a loyalty record exists
- no theme change
- no schema change

## Why this patch matters
The live production line is centered on the database-backed inquiry workflow and operator handling surface. The stable direction is to preserve the `/plan` bridge and improve backend handling incrementally, not destabilize the inquiry workspace. This patch keeps the loyalty concept visible but makes the inquiry screen safer and clearer for operators.  

## Install shape
This rooted patch is intended to be extracted from:
- `/home/cabnet/public_html/`

So the files land under:
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/...`
- `mykonos.cabnet.app/docs/releases/...`

## Notes
- This patch is intentionally non-destructive.
- It is a continuation/hardening step after the emergency loyalty partial fix.
