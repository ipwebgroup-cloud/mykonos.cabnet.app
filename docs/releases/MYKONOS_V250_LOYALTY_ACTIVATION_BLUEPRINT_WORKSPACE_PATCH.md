# Mykonos Inquiry Plugin v2.5.0 Loyalty Activation Blueprint Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.5.0-loyalty-activation-blueprint-workspace-public-html-rooted.zip`

## What changed
- kept the Loyalty Continuity workspace safe when loyalty storage is not installed
- upgraded the loyalty area from launch-readiness messaging into a structured activation-blueprint workspace
- added shared operator-facing panels for:
  - install-state overview
  - activation gates
  - safe rollout plan
  - recommended routes
- updated both toolbar partial names to keep the backend controller stable while pointing operators back to the Inquiry Queue during pre-launch mode
- updated the root continuity handoff file

## Why this patch matters
The loyalty workspace is no longer just a guarded placeholder. It now documents the intended rollout path clearly so the next structural release can introduce the storage layer without confusion, while keeping the live inquiry workflow clean and safe.

## Install path
- extract from `/home/cabnet/public_html/`
- files will land under:
  - `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/...`
  - `mykonos.cabnet.app/docs/releases/...`
  - `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`

## Notes
- no schema change
- no theme change
- production-safe plugin-only continuation
