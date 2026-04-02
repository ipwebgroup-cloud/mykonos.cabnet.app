# Mykonos Inquiry Platform v2.5.8 — Preference Signal Panel

## What changed
This patch adds a read-only **Preference Signals** panel to the top of the backend **Preferences** tab on the inquiry update screen.

The panel groups existing inquiry data into a faster operator scan:
- contact route
- stay signals
- experience signals

## Why this patch matters
The Preferences tab already contains the right fields, but operators still need to scan multiple controls to understand the guest's stated route, expectations, and experience cues.

This patch keeps all existing fields intact while giving the operator a cleaner first-pass summary before editing.

## Scope
- plugin-only
- backend detail screen only
- no schema change
- no public theme change
- no workflow logic change

## Files changed
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_preference_signal_panel.htm`
- `CHANGELOG.md`
- `docs/patches/MYKONOS_V258_PREFERENCE_SIGNAL_PANEL.md`
