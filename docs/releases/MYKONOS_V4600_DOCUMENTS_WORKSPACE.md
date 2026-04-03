# Mykonos v4.6.0 — Documents Workspace

## Package
- `mykonos-v4.6.0-documents-workspace-rooted-patch.zip`

## What changed
- added a new **Documents** tab to the backend inquiry update screen
- added **Documents Workspace**
- added **Document Packet Blueprint**
- added **Document Risk Guardrails**
- no schema change
- no `/plan` change
- no backend list or quick-action change

## Why this patch matters
The current line already supports communication, proposal, fulfillment, confirmation, closure, reopen, handoff, recovery, planning, intake, pricing, suppliers, scheduling, journey, partner coordination, and financial closure.

The next clean operator phase is **document readiness** so quote-style packets, confirmation summaries, and supporting documents can be shaped from the record without blurring continuity, ownership, timing, or pending items.

## Install
1. Merge the patch into:
   `public_html/mykonos.cabnet.app/`
2. Clear backend/cache if needed.
3. Open backend → **Mykonos Inquiries**.
4. Open an inquiry record.
5. Verify the new **Documents** tab renders and the three panels display normally.

## Verify
- update screen still renders without regressions
- **Documents** tab appears after **Financials**
- all three document panels render without PHP warnings
- no impact to `/plan` submission or backend list stability
