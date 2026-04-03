# Mykonos Plugin Handoff

## Current patch line
- Latest delivered patch: v2.3.5 loyalty handoff guardrails
- Patch type: plugin-only
- Archive root: `mykonos.cabnet.app/`

## Current safe state
- The backend inquiry update screen was recovered after loyalty partial errors.
- Loyalty partials now avoid the fragile partial-level `use Schema;` import pattern.
- Loyalty remains a guarded post-triage continuity concept, not part of the early live inquiry queue.

## Files touched by this patch
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_workspace_actions.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_loyalty_continuity_panel.htm`
- `docs/releases/MYKONOS_V235_LOYALTY_HANDOFF_GUARDRAILS_PATCH.md`
- `MYKONOS_PLUGIN_HANDOFF.md`

## Intent of this patch
- keep inquiry operations stable
- reduce the chance of operators moving records into loyalty too early
- preserve continuity notes for the next session if chat context is lost

## Next recommended direction
- continue with small plugin-only loyalty refinements
- avoid schema changes unless the loyalty workspace is ready to be completed end-to-end
- keep the public theme untouched unless there is a specific frontend requirement
