# Mykonos Inquiry Plugin v4.0.0 Pricing Workspace

## Package
- `mykonos-v4.0.0-pricing-workspace-rooted-patch.zip`

## What changed
- added a dedicated **Pricing** tab to the inquiry update screen
- introduced:
  - `Pricing Workspace`
  - `Pricing Range Blueprint`
  - `Pricing Risk Guardrails`
- keeps pricing posture separate from intake cleanup and proposal wording so operators can shape commercial ranges with clearer discipline

## Why this patch matters
The current line already covers intake normalization, planning, communication, proposal, fulfillment, confirmation, closure, reopen, handoff, and recovery.

The remaining clean operator phase was **pricing posture**: a dedicated place to decide whether the inquiry is ready for directional ranges, how the next commercial frame should be shaped, and what mistakes should be avoided before numbers become visible.

## Install
1. Merge the patch into:
   `public_html/mykonos.cabnet.app/`
2. Clear backend cache if needed.
3. Open backend → **Mykonos Inquiries**.
4. Open any inquiry record and verify:
   - the **Pricing** tab is visible
   - the three new pricing panels render without errors
   - no other tabs regress

## Notes
- changed-files-only patch
- zip root is `mykonos.cabnet.app/`
- no schema change
- no public `/plan` change
- no backend list/filter change
