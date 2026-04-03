# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed or only partially installed.
- The loyalty line now includes a guarded inquiry-side bridge, dry-run transfer scoring, staged loyalty record and touchpoint schema packets, outcome/timing planning, the first staged touchpoint outcome entry and execution field surfaces, a schema-aligned activation path for deliberate live transfer, the first real live loyalty touchpoint capture plus continuity command deck actions, and explicit decision-framing / next-step readability polish for active continuity records.

## This patch
- Version: `v5.1.0`
- Name: `loyalty decision framing and next-step visibility workspace`
- Type: plugin-only major patch
- Adds read-only live continuity framing around touchpoint outcomes, next review windows, referral posture, and return-value stewardship
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/config_filter.yaml`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V510_LOYALTY_DECISION_FRAMING_AND_NEXT_STEP_VISIBILITY_WORKSPACE_PATCH.md`

## Why this patch exists
The live loyalty record was operationally usable after the v5.0.0 command deck and touchpoint capture step, but the record still relied too heavily on operators manually interpreting timing, outcome posture, and whether a guest should be treated as referral-ready, return-value stewardship, reactivation, or simple watch.

This patch improves readability without widening scope:
- keeps Inquiry Queue as the live active-handling workspace
- keeps loyalty work narrow and operator-owned
- adds explicit next-step visibility
- adds decision framing so loyalty records do not drift into vague campaign handling
- improves inquiry-side visibility when a loyalty record is already linked

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Keep loyalty continuity focused on readable operator-owned stewardship rather than automation.
- The next major patch should focus on retention packet polish and evidence framing so a loyalty record can show why a guest is being retained, reactivated, or framed for referral/value handling in a cleaner at-a-glance operator structure.
