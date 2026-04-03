# Mykonos v5.7.0 — Referral Readiness Workspace

## Package
- `mykonos-v5.7.0-referral-readiness-workspace-rooted-patch.zip`

## What changed
- added a new **Referrals** tab on the backend inquiry update screen
- added **Referral Readiness Workspace**
- added **Referral Path Blueprint**
- added **Referral Risk Guardrails**

## Why this patch matters
The current line already supports repeat-guest and VIP relationship continuity. The next clean operator phase is a dedicated referral-readiness layer, so trusted-network fit, ownership, and timing are handled in one explicit workspace instead of being reconstructed from repeat or VIP memory alone.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_referral_readiness_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_referral_path_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_referral_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V5700_REFERRAL_READINESS_WORKSPACE.md`
- `CHANGELOG.md`

## Install
1. Merge the changed files into `public_html/mykonos.cabnet.app/`
2. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Open backend → **Mykonos Inquiries**
4. Open an inquiry and verify:
   - the **Referrals** tab appears
   - the three referral panels render without errors

## Notes
- backend-only change
- no schema change
- no public `/plan` change
- zip root is `mykonos.cabnet.app/`
