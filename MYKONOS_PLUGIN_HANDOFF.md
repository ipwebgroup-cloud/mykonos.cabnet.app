# Mykonos Plugin Handoff

## Current patch line
- Latest delivered patch: v2.3.7 loyalty routing cues
- Patch type: plugin-only
- Archive root: `mykonos.cabnet.app/`

## Current safe state
- Inquiry update screen remains protected from loyalty-partial crashes.
- Loyalty continuity still behaves as a guarded post-triage layer.
- Operators now see a recommended route that distinguishes active handling from continuity review and linked loyalty work.

## Files touched by this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `docs/releases/MYKONOS_V237_LOYALTY_ROUTING_CUES_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Intent of this patch
- make the next handling lane clearer inside the inquiry workspace
- keep retention work separate from active inquiry handling
- preserve a root continuity note in case the chat is interrupted

## Next recommended direction
- continue with plugin-only loyalty refinements
- avoid schema change until the loyalty workspace is ready end-to-end
- keep the public theme untouched unless a specific frontend requirement appears
