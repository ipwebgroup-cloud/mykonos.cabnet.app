# Mykonos v2.8.0 — Queue Command Board

## Package
- `mykonos-v2.8.0-queue-command-board-rooted-patch.zip`

## What changed
This major update shifts from update-screen-only operator guidance into the backend inquiry list itself.

The inquiry list page now becomes a stronger queue-control surface without changing the stable list filters, schema, or public `/plan` flow.

### Added on the backend inquiry list page
- **Queue Command Board**
  - live queue metrics
  - headline queue posture
  - triage-first scan block
- **Live Triage Lanes**
  - unassigned now
  - overdue follow-up
  - due today
  - proposal / waiting
- **Operator Triage Playbook**
  - read-only routing guidance for what to stabilize first before opening records one by one

## Why this matters
The update screen is already rich with operator continuity panels.

The next stronger usability step was to improve the list page so operators can:
- see queue pressure sooner
- jump into the right records faster
- keep owner clarity and follow-up discipline visible
- triage without over-expanding list filter complexity

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_toolbar.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_queue_command_board.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_queue_lane_board.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_operator_triage_playbook.htm`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Install
1. Upload the changed files into the matching project paths.
2. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Clear cache if needed:
   `php artisan cache:clear`
4. Open backend → **Mykonos Inquiries**

## Verify
- the inquiry list still renders normally
- the **New inquiry** button still works
- the top of the list now shows the queue command board
- triage lane records open the correct inquiry detail screen
- existing stable list filters still work

## Risk profile
- no schema change
- no public theme change
- no `/plan` bridge change
- no risky list filter expansion
- backend-only usability upgrade
