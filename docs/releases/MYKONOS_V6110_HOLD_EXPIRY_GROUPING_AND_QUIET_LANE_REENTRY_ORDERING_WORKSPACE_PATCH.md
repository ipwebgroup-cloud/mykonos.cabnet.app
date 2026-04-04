# Mykonos Loyalty Workspace v6.11.0 Hold-Expiry Grouping and Quiet-Lane Re-Entry Ordering Patch

## Package
- `mykonos-cabnet-v6.11.0-hold-expiry-grouping-and-quiet-lane-reentry-ordering-workspace-patch.zip`

## What changed
- added read-only loyalty cues for:
  - `hold_expiry_group_label`
  - `quiet_lane_reentry_order_label`
- added read-only supporting summaries for:
  - `hold_expiry_grouping_digest`
  - `quiet_lane_reentry_order_frame`
- added a new Overview panel:
  - `Hold-Expiry Grouping and Quiet-Lane Re-Entry Ordering`
- extended the linked inquiry loyalty snapshot with:
  - Hold expiry
  - Re-entry order
- extended loyalty list visibility with:
  - Hold Expiry
  - Re-Entry Order
- updated continuity files:
  - `MYKONOS_PLUGIN_HANDOFF.md`
  - `MYKONOS_CONTINUE_PROMPT.md`

## Why this patch exists
The loyalty workspace could already show hold-aging compression and quiet-lane re-entry readiness.

The remaining friction was human ordering: operators could tell whether a quiet hold was compact and re-entry-ready, but they still had to mentally group that hold by expiry posture and decide where it belonged in the re-entry scan order.

This patch keeps that decision human-owned while making the grouping and order more explicit.

## Install
1. Upload the zip contents into `/home/cabnet/public_html/`
2. Confirm files land under `mykonos.cabnet.app/...`
3. Clear cache only if backend output appears stale

## Refresh requirement
- No `php artisan plugin:refresh Cabnet.MykonosInquiry` is required
- Reason: this patch introduces no migrations and no schema changes

## Verify
1. Open backend → `Mykonos Inquiry` → `Loyalty Records`
2. Open an existing loyalty record
3. Confirm the new Overview readouts appear:
   - Hold-Expiry Group
   - Quiet-Lane Re-Entry Order
4. Confirm the new Overview panel renders
5. Open an inquiry with a linked loyalty record and confirm the loyalty continuity snapshot shows:
   - Hold expiry
   - Re-entry order
6. Confirm the loyalty list shows:
   - Hold Expiry
   - Re-Entry Order

## Notes
- Plugin-only patch
- Render-safe / schema-safe continuation
- Keeps Inquiry Queue stable as the live operational workspace
- Leaves the public `/plan` bridge untouched
