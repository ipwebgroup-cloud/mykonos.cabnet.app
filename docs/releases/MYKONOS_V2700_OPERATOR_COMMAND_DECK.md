# Mykonos v2.7.0 Operator Command Deck

## Package
- `mykonos-v2.7.0-operator-command-deck-rooted-patch.zip`

## What changed
This is a larger backend-only operator usability milestone that continues from the stabilized v2.6.x workspace line without touching the public `/plan` flow, schema, or backend list rendering.

### New Command tab
The inquiry update screen now includes a dedicated **Command** tab with three composite read-only panels:

- **Operator Command Deck**
  - top-level control surface for queue posture, guest readiness, commercial clarity, and safest next action
- **Next Guest Touch Blueprint**
  - suggests the safest next guest-facing route, tone, message focus, and highest-value missing facts
- **Handoff Packet Readiness**
  - checks whether ownership, notes, source trail, trip basics, and closure context are strong enough for a clean internal hand-off or reopen later

## Why this patch matters
The v2.6.x line added many granular scan panels across Internal, History, Raw, and Source. This update introduces a more operationally useful control layer where the assigned handler can land on one tab and quickly understand:

- what is happening now
- what matters next
- how to approach the next guest touch
- whether the record is safe for hand-off

## Risk posture
- backend-only
- no schema change
- no list filter change
- no quick-action routing change
- no public theme change

## Changed files
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_operator_command_deck_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_next_guest_touch_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_handoff_packet_readiness_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V2700_OPERATOR_COMMAND_DECK.md`
