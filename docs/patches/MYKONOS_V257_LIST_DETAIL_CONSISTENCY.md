# Mykonos Inquiry Platform v2.5.7 — List / Detail Consistency Polish

## What changed
- aligned backend inquiry list terminology with the detail screen
- list now uses operator-friendly status and priority labels
- source column now shows a safe fallback when no explicit source title exists
- owner column now shows `Unassigned` when no assignee is set
- queue / follow-up column now mirrors the follow-up queue wording used on the update screen

## Why this patch matters
The recent line improved the inquiry detail screen substantially, but the list still exposed a few raw / blank values that forced operators to translate the workflow state mentally.

This patch keeps the list conservative and stable while making the list and detail screens feel like the same workflow surface.

## Scope
- no schema change
- no public theme change
- no list filter expansion
- no new workflow logic
