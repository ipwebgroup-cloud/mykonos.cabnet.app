# Mykonos v5.6.0 — VIP Relationship Workspace

## Package
- `mykonos-v5.6.0-vip-relationship-workspace-rooted-patch.zip`

## What changed
- added a new **VIP Relationship** tab on the inquiry update screen
- added **VIP Relationship Workspace**
- added **VIP Relationship Blueprint**
- added **VIP Relationship Risk Guardrails**

## Why this patch matters
The current operator line already covers repeat-guest readiness. The next clean phase is long-cycle premium relationship continuity so reusable trust, taste, service-pattern, and ownership memory stay visible instead of being reconstructed from hindsight.

## Install
1. Upload the changed files into `public_html/mykonos.cabnet.app`
2. Clear cache if needed
3. Open backend → **Mykonos Inquiries**
4. Open an inquiry and verify the new **VIP Relationship** tab renders

## Verify
- inquiry update screen still renders normally
- **VIP Relationship** tab appears
- all three new panels render without PHP or YAML errors
- no public `/plan` behavior changed

## Notes
- backend-only
- no schema change
- zip root is `mykonos.cabnet.app/`
