# Mykonos Inquiry Plugin v2.3.6 Loyalty Readiness Checklist Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.6-loyalty-readiness-checklist-public-html-rooted.zip`

## What changed
- added a clearer inquiry-side readiness checklist before loyalty handoff actions
- actions now explain why handoff stays guarded when the inquiry still belongs in active handling
- improved the continuity snapshot so operators can see inquiry anchor and original focus even before or after loyalty linkage
- updated the root handoff markdown file for crash recovery / continuity
- no schema change
- no theme change

## Why this patch matters
The live line should make it obvious when loyalty is a proper retention step and when the request should remain in the active inquiry queue. This patch reduces operator guesswork without expanding the schema.

## Root handoff file
This patch includes:
- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
