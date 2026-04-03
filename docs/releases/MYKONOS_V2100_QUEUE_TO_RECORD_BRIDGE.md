# Mykonos v2.10.0 — Queue-to-Record Bridge

## Package
- `mykonos-v2.10.0-queue-to-record-bridge-rooted-patch.zip`

## What changed
This is a backend-only operator milestone that builds on the queue command board and the action workspace.

It upgrades the backend inquiry list page from a queue snapshot into a stronger **list-to-record routing surface**.

### New list-page operator surfaces
- **Queue-to-Record Bridge Board**
  - maps live queue conditions into the safest first tab to inspect after opening a record
  - introduces scan-first routing such as:
    - Action-first
    - Command-first
    - Source-first
    - Continuity-first
- **Priority Opening Routes**
  - surfaces sample records that fit each opening posture
  - gives the operator a clearer route before entering the record
- **Queue-to-Record Playbook**
  - documents how to move from queue scanning into the correct record workspace without over-scanning every tab

## Why this patch matters
The queue page already showed metrics and live lanes.

The remaining friction was the transition from queue page to inquiry detail screen. Operators still had to decide from scratch where to start every time they opened a record.

This patch turns the list page into a stronger bridge between:
- queue posture
- record-opening intent
- the correct first workspace on the inquiry detail screen

## Scope
- backend-only
- no schema change
- no public theme change
- no `/plan` change
- no risky list-filter expansion

## Changed files
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_toolbar.htm`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_queue_to_record_bridge_board.htm`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_record_opening_routes_board.htm`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_queue_to_record_playbook.htm`
- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `mykonos.cabnet.app/CHANGELOG.md`
- `mykonos.cabnet.app/docs/releases/MYKONOS_V2100_QUEUE_TO_RECORD_BRIDGE.md`

## Install
1. Upload the changed files into the matching project paths.
2. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Clear cache if needed:
   `php artisan cache:clear`
4. Open backend → **Mykonos Inquiries**

## Verify
1. The list page still renders normally.
2. The existing **Queue Command Board** still shows.
3. A new **Queue-to-Record Bridge** section appears below it.
4. The bridge surfaces show:
   - route cards
   - priority opening routes
   - a queue-to-record playbook
5. Clicking record links still opens the normal inquiry update screen.

## Notes
- This patch is intentionally conservative about list stability.
- It extends the queue page as a read-only operator decision surface without touching the query/filter baseline.
