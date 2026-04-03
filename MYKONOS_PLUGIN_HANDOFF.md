# MYKONOS PLUGIN HANDOFF

## Current line
- Live project root: `mykonos.cabnet.app`
- Active plugin: `plugins/cabnet/mykonosinquiry`
- Public source-of-truth direction remains the DB-backed inquiry workflow from the v41 integration line.

## Current stability state
- Inquiry Queue remains the live operational workspace.
- Loyalty Continuity still renders safely even when the loyalty storage layer is not installed or only partially installed.
- The loyalty line now includes a guarded inquiry-side bridge, dry-run transfer scoring, staged loyalty record and touchpoint schema packets, outcome/timing planning, the first staged touchpoint outcome entry and execution field surfaces, a schema-aligned activation path for deliberate live transfer, the first real live loyalty touchpoint capture plus continuity command deck actions, explicit decision-framing / next-step readability polish for active continuity records, and a cleaner retention-packet evidence frame for live stewardship use.

## This patch
- Version: `v5.2.0`
- Name: `loyalty retention packet and evidence framing workspace`
- Type: plugin-only major patch
- Adds at-a-glance packet framing so live loyalty records show evidence strength, retention recommendation, packet summary, and source/touchpoint rationale in a cleaner operator structure
- No theme change
- No schema change

## Files included in this patch
- `plugins/cabnet/mykonosinquiry/controllers/LoyaltyRecords.php`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_retention_packet_overview_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_continuity_evidence_frame_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `docs/releases/MYKONOS_V520_LOYALTY_RETENTION_PACKET_AND_EVIDENCE_FRAMING_WORKSPACE_PATCH.md`

## Why this patch exists
The live loyalty line was already operationally usable, but the reasoning behind each retention, reactivation, referral, or return-value record was still spread across multiple fields and touchpoint notes.

This patch makes that rationale easier to read:
- turns the record into a clearer operator packet
- keeps loyalty work narrow and human-owned
- improves the handoff between linked inquiry context and live loyalty stewardship
- avoids widening into campaign or automation behavior

## Safest next direction
- Keep Inquiry Queue stable as the live workspace.
- Keep loyalty continuity focused on readable operator-owned stewardship rather than automation.
- The next major patch should focus on continuity packet actions and operator notes packaging so the loyalty record can produce a cleaner ready-to-act brief for reactivation, referral-safe follow-up, or return-value stewardship.
