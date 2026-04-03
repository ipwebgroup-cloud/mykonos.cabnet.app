# Mykonos v3.4.0 — Closure Workspace

## Package
- `mykonos-v3.4.0-closure-workspace-rooted-patch.zip`

## What changed
- added a new **Closure** tab to the backend inquiry update screen
- added **Closure Workspace** as a composite closure / pause / reopen posture panel
- added **Closure Decision Blueprint** for explicit outcome and reopen-path handling
- added **Closure Risk Guardrails** for ownership, continuity, checkpoint, and reopen discipline

## Why this matters
The current line already gives operators queue triage, action control, communication guidance, proposal shaping, fulfillment readiness, and confirmation posture.

The next safe major layer is closure discipline: making sure a record does not drift into silent loss, unclear pause, or weak reopen context. This patch turns closure into a readable operator decision without changing the public flow or schema.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_decision_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_closure_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`

## Install
Merge the zip contents into:

`public_html/mykonos.cabnet.app/`

The zip is rooted correctly at:

`mykonos.cabnet.app/`

## Verify
1. Open backend → **Mykonos Inquiries**
2. Open any inquiry record
3. Confirm the new **Closure** tab appears
4. Confirm the three new read-only closure panels render without affecting save/update behavior
5. Confirm existing quick actions, history, and public `/plan` flow remain unchanged
