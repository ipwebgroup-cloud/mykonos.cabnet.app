# Mykonos Inquiry Plugin v2.11.0 Operator List UI Foundation

## Package
- `mykonos-v2.11.0-operator-list-ui-foundation-rooted-patch.zip`

## Why this release exists
The new queue-side boards improved operator workflow, but real-screen testing exposed a layout regression on the backend inquiry list page: long card copy could overlap across columns instead of wrapping cleanly.

This release stabilizes the list page before adding more feature weight.

## What changed
- added a shared backend list-page UI style partial for:
  - safe text wrapping
  - predictable card height behavior
  - better responsive stacking on narrower widths
- updated the following list-page panels to use the shared UI foundation:
  - Queue Command Board
  - Live Triage Lanes
  - Operator Triage Playbook
  - Queue-to-Record Bridge Board
  - Priority Opening Routes
  - Queue-to-Record Playbook
- preserved all existing query logic and routing guidance
- introduced no schema change
- introduced no `/plan` or theme change
- left stable filters and quick actions untouched

## Install
1. Upload the changed plugin files into `plugins/cabnet/mykonosinquiry`
2. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Clear backend/cache if needed:
   `php artisan cache:clear`
4. Open backend → **Mykonos Inquiries**

## Verify
1. Confirm queue metric cards wrap cleanly instead of bleeding into adjacent columns
2. Confirm Queue-to-Record Bridge cards wrap cleanly at desktop and narrower widths
3. Confirm Live Triage Lane records keep right-side queue meta on its own line block
4. Confirm no blank list page regression occurs

## Scope note
This is a stabilization-first release. The strongest next feature work should build on this safer list-page foundation instead of layering more UI on top of broken wrapping.
