# MYKONOS_V6320_OWNER_REVIEW_SLOT_SEQUENCE_AND_QUEUE_BACKLOG_VISIBILITY_WORKSPACE_PATCH.md

## Package
- `mykonos-cabnet-v6.32.0-owner-review-slot-sequence-and-queue-backlog-visibility-workspace-patch.zip`

## Current state assessment
The uploaded rooted project state is already deep in the guarded Loyalty Continuity Workspace line and the live operational workspace remains the Inquiry Queue.

The previous rooted line already compressed loyalty reading through:
- acceptance confirmation handoff compression
- quiet-lane return checkpoint framing
- queue-scan prioritization cues
- human review timing clarity

The next safest move was not schema work and not public-flow work.
It was another plugin-only readability step that makes queue scanning more direct for operators.

## What changed
This patch adds two new conservative loyalty readability cues:

- `owner_review_slot_sequence_label`
- `queue_backlog_visibility_label`

It also adds:
- `owner_review_slot_sequence_digest`
- `queue_backlog_visibility_frame`

### Workspace effect
The loyalty workspace now translates the latest quiet-lane / queue timing state into:
- the next owner-led review order
- whether the record should stay at the front backlog, visible backlog, or deeper parked backlog

### Surfaces updated
- loyalty record Overview tab
- loyalty record list columns
- linked inquiry loyalty continuity snapshot

## Files changed
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/models/LoyaltyRecord.php`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/models/loyaltyrecord/fields.yaml`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/models/loyaltyrecord/columns.yaml`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_owner_review_slot_sequence_queue_backlog_visibility_panel.htm`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `mykonos.cabnet.app/MYKONOS_PLUGIN_HANDOFF.md`
- `mykonos.cabnet.app/MYKONOS_CONTINUE_PROMPT.md`

## Install
Upload the rooted patch contents into:
- `/home/cabnet/public_html/`

No migration is added.
No schema alignment is added.
Do **not** run `php artisan plugin:refresh Cabnet.MykonosInquiry` for this patch.

Clear cache only if backend output appears stale:
- `php artisan cache:clear`

## Verify
1. Open backend → Loyalty Records
2. Confirm the list renders
3. Confirm new list readability fields appear:
   - `Review Sequence`
   - `Backlog Visibility`
4. Open a loyalty record
5. Confirm the new Overview panel renders:
   - `Owner Review-Slot Sequence and Queue Backlog Visibility`
6. Open a linked inquiry with loyalty continuity visible
7. Confirm the loyalty snapshot shows the same two new cues

## Strongest next step
A safe next continuation would stay in the same lane:
- owner handoff sequencing clarity
- same-shift queue backlog compression
- review-slot escalation readability

No public `/plan` change is needed for this patch.
