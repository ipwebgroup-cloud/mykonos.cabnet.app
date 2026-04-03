# Mykonos Inquiry Plugin v2.3.8 Loyalty Workspace Render Fix Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.8-loyalty-workspace-render-fix-public-html-rooted.zip`

## What changed
- added the missing backend controller view templates for the Loyalty Continuity workspace:
  - `controllers/loyaltyrecords/index.htm`
  - `controllers/loyaltyrecords/create.htm`
  - `controllers/loyaltyrecords/update.htm`
- this restores the backend content area for the Loyalty Continuity section instead of leaving a blank page shell
- keeps the existing loyalty guardrails and crash-safe inquiry partials in place
- no schema change
- no theme change

## Why this patch matters
The backend route and side menu can load correctly while the workspace body still appears blank if the controller scaffolding is incomplete. This patch completes the missing render layer so the loyalty workspace behaves like a real OctoberCMS backend area.

## Install
- extract the zip from `/home/cabnet/public_html/`
- allow overwrite

## Verify
1. Open backend → **Mykonos Inquiries** → **Loyalty Continuity**
2. Confirm the list area renders instead of a blank content pane
3. Open a record and confirm the update form renders
4. Click **New Loyalty Record** and confirm the create form renders
