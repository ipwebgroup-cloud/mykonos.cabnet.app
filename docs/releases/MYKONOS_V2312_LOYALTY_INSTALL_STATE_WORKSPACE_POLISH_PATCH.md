# Mykonos Inquiry Plugin v2.3.12 Loyalty Install-State Workspace Polish Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.12-loyalty-install-state-workspace-polish-public-html-rooted.zip`

## What changed
- kept the Loyalty Continuity workspace plugin-only
- no schema change
- no theme change
- improved the guarded loyalty workspace screens when storage is not installed yet
- added clearer install-state messaging on:
  - loyalty list workspace
  - loyalty create page
  - loyalty update page
- changed the loyalty toolbar so it no longer presents a live create action when the loyalty tables do not exist
- updated the root handoff file for crash recovery continuity

## Why this patch matters
The loyalty workspace is currently a guarded shell in this environment. This patch makes that state more explicit and reduces operator confusion while keeping the main inquiry queue as the real active workspace.

## Notes
- This patch is intentionally production-safe.
- Loyalty storage remains deferred to a controlled future release.
