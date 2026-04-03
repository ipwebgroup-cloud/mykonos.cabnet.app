# Mykonos v5.5.1 — Repeat Guest Workspace YAML Hotfix

## Purpose
Restore backend inquiry update screen rendering after a malformed indentation block in `models/inquiry/fields.yaml` broke YAML parsing near the **Repeat Guest** workspace entries.

## What changed
- re-indented:
  - `repeat_guest_readiness_workspace_panel`
  - `repeat_guest_blueprint_panel`
  - `repeat_guest_risk_guardrails_panel`
- kept the patch backend-only
- no schema change
- no public `/plan` change
- no backend list change

## Install
1. Merge the contents of `mykonos.cabnet.app/` into the live project root.
2. Clear cache if needed.
3. Reload backend → **Mykonos Inquiries** → open an inquiry update screen.

## Verify
- the inquiry update screen renders again
- the **Repeat Guest** tab appears normally
- the **Internal** tab and other tabs render without YAML parse errors
