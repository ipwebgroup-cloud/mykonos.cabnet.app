# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed or only partially installed.
- The loyalty line now includes a guarded inquiry-side bridge, dry-run transfer scoring, staged loyalty record and touchpoint schema packets, outcome/timing planning, the first staged touchpoint outcome entry and execution field surfaces, a schema-aligned activation path for deliberate live transfer, and the first real live loyalty touchpoint capture plus continuity command deck actions.

## This patch
- Version: `v5.0.0`
- Name: `loyalty live touchpoint capture and continuity command deck`
- Type: plugin-only major patch
- Adds sanctioned continuity record actions, structured live touchpoint capture, list-side touchpoint visibility, and inquiry-side linked continuity posture visibility
- No theme change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_command_deck_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_live_touchpoint_capture_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V500_LOYALTY_LIVE_TOUCHPOINT_CAPTURE_AND_CONTINUITY_COMMAND_DECK_PATCH.md`

## Why this patch exists
The loyalty activation line was structurally safe after the v4.9.0 schema alignment work, but the live loyalty record still lacked the first practical operator surface for real continuity execution.

This patch closes that operational gap safely:
- it keeps Inquiry Queue as the live intake and active-handling workspace
- it keeps loyalty work deliberately narrow
- it adds explicit record-side continuity actions instead of vague freeform state drift
- it adds structured touchpoint capture that also keeps timing fields readable in the list and in inquiry-side loyalty visibility

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Treat the new loyalty command deck as the sanctioned first-wave continuity action surface rather than expanding into broad campaign tooling.
- The next major patch should focus on loyalty record detail/readability polish around touchpoint outcomes, next-step visibility, and referral-return-value decision framing without turning the workspace into an automated marketing system.
