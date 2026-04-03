# Mykonos v2.9.0 — Action Workspace

## Package
- `mykonos-v2.9.0-action-workspace-rooted-patch.zip`

## What changed
This major backend-only milestone extends the operator-side sequence after the queue-focused v2.8.0 line.

It adds a dedicated **Action** tab to the inquiry update screen so operators have a single record-level workspace for deciding the safest next move before editing detailed fields.

### Added panels
- **Operator Action Workspace**
  - queue control
  - guest coverage
  - continuity posture
  - safest immediate next action
- **Next Move Execution**
  - recommended route
  - message goal
  - what to include
  - what to avoid
- **Record Transition Guardrails**
  - clarification readiness
  - proposal-shaping readiness
  - confirmation-style posture
  - closure / reopen discipline

## Why this matters
The current line already provides:
- stronger list-side triage via the Queue Command Board
- dense read-only operator guidance on the update screen
- stable quick actions and workflow continuity

The remaining major usability gap was that operators still had to mentally assemble the actual next move from multiple tabs. This update creates a dedicated record-level action surface without disturbing persistence, schema, list stability, or the public `/plan` bridge.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_operator_action_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_next_move_execution_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_record_transition_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V2900_ACTION_WORKSPACE.md`

## Install
1. Upload the changed files into the project root, preserving paths from `mykonos.cabnet.app/...`
2. Run:
   `php artisan plugin:refresh Cabnet.MykonosInquiry`
3. Clear backend/cache if needed:
   `php artisan cache:clear`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open any inquiry record
3. Confirm a new **Action** tab exists
4. Confirm the three new read-only panels render without breaking the update screen
5. Confirm no public `/plan` flow, list filter, or quick-action regression is introduced

## Notes
- no schema change
- no public theme change
- no list filter expansion
- intentionally safe and backend-only
