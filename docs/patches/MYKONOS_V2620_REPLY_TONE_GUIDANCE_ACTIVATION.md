# MYKONOS v2.6.20 — Reply Tone Guidance Activation

## Scope
Changed-files-only patch for the stabilized `v2.6` operator workspace line.

## What this patch does
- activates the existing read-only **Reply Tone Guidance** panel on the **Internal** tab
- gives operators one scan-first surface for:
  - safest reply tone
  - pacing
  - preferred contact route
  - suggested guest-facing reply shape

## Why this patch is safe
- backend detail screen only
- no schema change
- no public theme change
- no list filter change

## Files changed
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_reply_tone_guidance_panel.htm`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
