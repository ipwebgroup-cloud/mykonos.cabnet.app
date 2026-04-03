# Mykonos Inquiry Plugin v2.6.0 Loyalty Transition Scorecard Workspace Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.6.0-loyalty-transition-scorecard-workspace-public-html-rooted.zip`

## What changed
- kept the Loyalty Continuity workspace safe when loyalty storage is not installed
- upgraded the loyalty area from an activation blueprint into a more practical transition scorecard workspace
- added shared operator-facing panels for:
  - continuity transition scorecard
  - activation scenarios
- retained the existing install-state overview, rollout plan, and route guidance panels
- updated both toolbar partial names to keep the backend controller stable while clarifying that the workspace is still in transition mode
- updated the root continuity handoff file

## Why this patch matters
The loyalty workspace now does more than describe a future release. It helps operators think through readiness, continuity value, and separation boundaries before the first storage-backed loyalty rollout is introduced.

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
