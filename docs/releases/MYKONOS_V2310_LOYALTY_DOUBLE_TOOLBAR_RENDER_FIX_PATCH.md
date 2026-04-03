# Mykonos Inquiry Plugin v2.3.10 Loyalty Double Toolbar Render Fix Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.10-loyalty-double-toolbar-render-fix-public-html-rooted.zip`

## What changed
- plugin-only patch
- no schema change
- no theme change
- added:
  - `plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/__toolbar.htm`
- updated root continuity file:
  - `MYKONOS_PLUGIN_HANDOFF.md`

## Why this patch exists
The live Loyalty Continuity backend route is currently resolving a double-underscore toolbar partial name:

- `__toolbar.htm`

The archive state already includes `_toolbar.htm`, but the list widget is requesting `__toolbar.htm`, causing the workspace to fail during render.

This patch restores compatibility by supplying the expected partial directly, without changing the loyalty data model or touching the public theme flow.

## Install target
Extract from:

- `/home/cabnet/public_html/`

So files land under:

- `mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/...`

## Verify
- open backend → Mykonos Inquiries → Loyalty Continuity
- confirm the loyalty list screen renders instead of throwing a partial-not-found error
