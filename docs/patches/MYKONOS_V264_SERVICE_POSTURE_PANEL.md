# Mykonos Inquiry Platform v2.6.4 — Service Posture Panel

## Scope
Backend detail screen only.

## What changed
- added a read-only **Service Posture** panel to the **Internal** tab
- surfaces:
  - core service picture
  - experience-specific signals
  - planning continuity
- helps operators see whether the inquiry is still general planning, targeted service planning, or already rich enough for proposal work

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_service_posture_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/patches/MYKONOS_V264_SERVICE_POSTURE_PANEL.md`

## Safety
- no schema change
- no public theme change
- no list filter change
- no new persistence logic
