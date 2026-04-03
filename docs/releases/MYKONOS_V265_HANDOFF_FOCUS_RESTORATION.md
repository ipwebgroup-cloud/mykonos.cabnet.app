# Mykonos Inquiry Platform v2.6.25 — Handoff Focus Restoration

## Summary

This patch restores the read-only **Handoff Focus** panel to the live Internal tab on the backend inquiry update screen.

## Why this patch exists

The repository already contains the `_handoff_focus_panel.htm` partial and an earlier `v2.6.2` handoff-focus commit, but the current stabilized `fields.yaml` wiring does not expose that panel on the active inquiry form.

After the `v2.6.24` operator workspace activation alignment step, this remained the clearest backend-only workspace aid still present in the repo but not visible in the current form layout.

## What this restores

- **Handoff Focus** panel on the **Internal** tab
- scan-first cues for:
  - guest focus
  - queue checkpoint
  - current working picture

## Changed files

- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V265_HANDOFF_FOCUS_RESTORATION.md`

## Non-regression intent

- no schema change
- no public theme change
- no backend list filter change
- no quick-action routing change
- no `/plan` bridge change

## Verify

1. Open backend → **Mykonos Inquiries**
2. Open an existing inquiry record
3. Open the **Internal** tab
4. Confirm **Handoff Focus** now appears in the operator workspace
5. Confirm the update screen still renders normally
6. Confirm the public `/plan` flow remains untouched
