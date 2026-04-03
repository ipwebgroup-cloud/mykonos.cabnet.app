# Mykonos v4.5.0 — Financial Closure Workspace

## Package
- `mykonos-v4.5.0-financial-closure-workspace-rooted-patch.zip`

## What changed
- adds a new **Financials** tab to the inquiry update screen
- adds **Financial Closure Workspace**
- adds **Deposit Commitment Blueprint**
- adds **Financial Risk Guardrails**

## Why this patch matters
The current operator line already separates pricing, supplier readiness, scheduling, journey, and partner coordination.

The next clean operator phase is **financial closure discipline** so payment posture, deposit logic, and commercial lock checkpoints live in one explicit workspace instead of being blurred across Pricing, Confirmation, and Closure.

This keeps the update backend-only and production-safe.

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_financial_closure_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_deposit_commitment_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_financial_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V4500_FINANCIAL_CLOSURE_WORKSPACE.md`
- `CHANGELOG.md`

## Notes
- no schema change
- no public theme change
- no `/plan` bridge change
- no backend list filter expansion
