# Mykonos Inquiry Platform v2.12.0 — List Workspace Shell

## Package
- `mykonos-v2.12.0-list-workspace-shell-rooted-patch.zip`

## Why this update exists
The latest list-side operator boards became useful, but the queue page grew too tall and forced operators to scroll through multiple large read-only surfaces on every visit.

This update keeps all existing queue logic and bridge logic intact while reorganizing the backend inquiry list page into a safer, lower-fatigue workspace shell.

## What changed
- added a new shared list-page shell styles partial:
  - `plugins/cabnet/mykonosinquiry/controllers/inquiries/_operator_list_workspace_styles.htm`
- rewired the list toolbar partial:
  - `plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_toolbar.htm`
- grouped the existing list-side operator surfaces into expandable sections using native `<details>` panels:
  - Queue overview
  - Live triage lanes
  - Operator triage playbook
  - Queue-to-record bridge
- preserved the existing underlying partials and metrics logic:
  - `queue_command_board`
  - `queue_lane_board`
  - `operator_triage_playbook`
  - `queue_to_record_bridge_board`
  - `record_opening_routes_board`
  - `queue_to_record_playbook`

## What this does not change
- no schema change
- no public `/plan` change
- no backend list filter expansion
- no record update-screen workflow change
- no quick-action routing change

## Expected result
The backend inquiry list remains operator-rich, but the page becomes easier to scan because only the top queue sections stay open by default.
The deeper routing guidance remains available without forcing constant vertical scrolling.

## Install
1. Upload the changed files into the same paths under your OctoberCMS project root.
2. Clear October/backend cache if needed.
3. Open backend → **Mykonos Inquiries**.
4. Verify:
   - Queue overview is open by default
   - Live triage lanes is open by default
   - Playbook and Queue-to-record bridge are collapsed by default
   - Expanding and collapsing sections does not break list rendering

## Notes
This is intentionally a backend-only structural usability release.
It is the safest major continuation after the list-board UI stabilization step because it improves operator scan speed without disturbing the stable inquiry persistence and public frontend bridge.
