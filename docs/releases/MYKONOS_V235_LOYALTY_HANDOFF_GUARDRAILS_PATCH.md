# Mykonos Inquiry Plugin v2.3.5 Loyalty Handoff Guardrails Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.5-loyalty-handoff-guardrails-public-html-rooted.zip`

## What changed
- added stronger inquiry-side loyalty handoff guardrails
- early-stage inquiries now show loyalty actions as intentionally locked until the record has progressed far enough in active handling
- improved continuity snapshot visibility with safer date rendering and extra retention cues
- added a root-level handoff markdown file for crash recovery / continuity
- no schema change
- no theme change

## Why this patch matters
The live line should keep loyalty as a post-triage retention layer, not something operators trigger too early while a request is still being actively worked in the inquiry queue.

## Root handoff file
This patch includes:
- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`

Use that file as the continuity source if a future chat is interrupted.
