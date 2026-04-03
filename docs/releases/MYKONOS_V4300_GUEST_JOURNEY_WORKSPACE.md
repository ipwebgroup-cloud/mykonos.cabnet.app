# Mykonos Inquiry Plugin v4.3.0 Guest Journey Workspace

## Package
- `mykonos-v4.3.0-guest-journey-workspace-rooted-patch.zip`

## What changed
- added a new backend **Journey** tab on the inquiry update screen
- introduced:
  - `Guest Journey Workspace`
  - `Journey Sequence Blueprint`
  - `Journey Risk Guardrails`
- helps operators sequence the guest experience across:
  - arrival / departure
  - service rhythm
  - guest scale
  - operator checkpoints
- keeps the change backend-only
- no schema change
- no public `/plan` change
- no risky list/filter expansion

## Why this patch matters
The current line already supports intake cleanup, planning, pricing, supplier-readiness, and scheduling posture.

The next clean operator phase is **guest-journey sequencing**: shaping the overall experience arc without mixing that work into raw scheduling, supplier prep, or proposal wording.

This patch gives operators a dedicated place to think through the guest journey as a continuity-led sequence before downstream execution language becomes too confident.

## Install
1. Merge the patch contents into:
   `public_html/mykonos.cabnet.app/`
2. Clear cache if needed:
   `php artisan cache:clear`
3. Open backend → **Mykonos Inquiries**
4. Open an inquiry and verify:
   - the new **Journey** tab is visible
   - the three new journey panels render
   - the existing tabs and editable fields still load normally

## Notes
- zip root is:
  `mykonos.cabnet.app/`
- this patch is **changed-files-only**
- this patch continues from the local v4.2.0 scheduling workspace line
