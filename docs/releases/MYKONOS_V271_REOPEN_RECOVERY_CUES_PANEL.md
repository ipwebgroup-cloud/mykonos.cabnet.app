# Mykonos Inquiry Plugin v2.6.31 Reopen Recovery Cues Panel

## Package
- `mykonos-v2.6.31-reopen-recovery-cues-panel-rooted-patch.zip`

## What changed
- added a new read-only **Reopen Recovery Cues** panel to the **Raw** tab
- placed it between:
  - **Payload Alignment Signals**
  - **Raw Payload**
- helps operators judge whether the inquiry can be safely reopened or handed off later without depending too heavily on memory or raw JSON
- keeps the patch backend-only and production-safe

## Why this patch matters
The current operator workspace already has strong scan-first guidance across the Internal, History, and Raw tabs.

After **Raw Payload Framing** and **Payload Alignment Signals**, the remaining safe refinement is to show whether the record itself now carries enough continuity anchors for future recovery, or whether the operator should still promote more context into the working summary or timeline before parking the case.

This improves reopen and hand-off discipline without changing schema, workflow logic, quick actions, or the public `/plan` flow.

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_reopen_recovery_cues_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V271_REOPEN_RECOVERY_CUES_PANEL.md`

## Install
1. Upload the patch files into the project root, preserving paths from `mykonos.cabnet.app/...`
2. If deploying plugin-only files manually, place them under:
   - `plugins/cabnet/mykonosinquiry/...`
3. Run:
   - `php artisan plugin:refresh Cabnet.MykonosInquiry`
4. Clear cache if needed:
   - `php artisan cache:clear`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open an existing inquiry
3. Open the **Raw** tab
4. Confirm this sequence appears:
   - **Raw Payload Framing**
   - **Payload Alignment Signals**
   - **Reopen Recovery Cues**
   - **Raw Payload**
5. Confirm the new panel renders without backend form errors
6. Confirm `/plan`, list rendering, and quick actions remain unaffected

## Notes
- no schema change
- no backend list filter change
- no public theme change
- no public `/plan` bridge change
- safe continuation of the **v2.6.x Operator Workspace Consolidation** line
