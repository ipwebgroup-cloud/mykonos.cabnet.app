# Mykonos Inquiry Plugin v3.1.0 — Proposal Workspace

## Package
- `mykonos-v3.1.0-proposal-workspace-rooted-patch.zip`

## What changed
This patch adds a new backend-only **Proposal** tab to the inquiry update screen so operators can move from queue triage, action posture, and communication strategy into disciplined commercial shaping.

### New panels
- **Proposal Workspace**
- **Offer Shape Blueprint**
- **Proposal Risk Guardrails**

## Why this matters
The current operator line already supports:
- internal workflow scanning
- queue triage
- action planning
- communication guidance

The next safe major step is a dedicated proposal-shaping layer that helps operators build premium starter offers and continuity-led follow-up without changing schema, the public `/plan` flow, or conservative backend list behavior.

## Files changed
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_proposal_workspace_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_offer_shape_blueprint_panel.htm`
- `plugins/cabnet/mykonosinquiry/controllers/inquiries/_proposal_risk_guardrails_panel.htm`
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/releases/MYKONOS_V3100_PROPOSAL_WORKSPACE.md`

## Install
Merge the zip contents into the live app root:
- `public_html/mykonos.cabnet.app/`

Then refresh the backend and open **Mykonos Inquiries** → open a record → verify the new **Proposal** tab renders cleanly.

## Notes
- No schema change
- No theme change
- No `/plan` bridge change
- No risky list filter change
