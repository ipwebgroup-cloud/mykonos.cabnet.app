# Mykonos Inquiry Plugin v2.3.7 Loyalty Routing Cues Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.7-loyalty-routing-cues-public-html-rooted.zip`

## What changed
- added a recommended route summary inside loyalty workspace actions so operators can immediately see whether the inquiry belongs in active handling, continuity review, or an existing loyalty record
- improved the continuity snapshot with routing signals pulled from the inquiry context
- preserved the existing loyalty crash guards and safe no-schema behavior
- updated the root handoff markdown file for crash recovery / continuity
- no schema change
- no theme change

## Why this patch matters
The live line should make the next handling lane obvious without forcing operators to interpret scattered workflow fields on their own. This patch adds routing cues while keeping loyalty continuity safely separated from the active inquiry queue.

## Root handoff file
This patch includes:
- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
