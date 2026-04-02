## v2.6.14 — Proposal Readiness Panel
- added a read-only Proposal Readiness panel to the Internal tab
- surfaces package readiness, clarification posture, and the safest next proposal-shaping move
- keeps the patch backend-only with no schema or public theme change


## v2.6.13 - Decision Posture Panel
- added a read-only **Decision Posture** panel to the Internal tab
- frames the safest next operator decision across assignment, contact, package shaping, and commercial pacing
- keeps operator workspace consolidation moving without schema or public-flow changes

## v2.6.12 - Commercial Posture Panel
- added a read-only **Commercial Posture** panel on the backend inquiry **Internal** tab
- surfaces budget framing, package depth, pace, and commercial next-move posture for faster operator scan
- backend-only refinement with no schema change and no public theme change

## v2.6.11 — Response Packaging Panel
- added a read-only **Response Packaging** panel to the Internal tab
- surfaces what should be packaged versus what still needs confirmation before the next guest-facing move
- keeps operator workspace consolidation moving without schema or public-flow changes

## v2.6.10 — Risk & Sensitivity Panel
- added a read-only **Risk & Sensitivity** panel to the Internal tab
- surfaces urgency, privacy, family, and dietary signals for safer hand-off continuity
- keeps operator workspace consolidation moving without schema or public-flow changes

# Changelog

## v2.6.9 — Next-Step Framing Panel
- added a read-only Next-Step Framing panel to the Internal tab
- surfaces the most appropriate next move from the current workflow, ownership, contact, and follow-up posture
- keeps operator workspace consolidation moving without schema or public-flow changes


## v2.6.7 - Source & Entry Posture Panel
- added a read-only **Source & Entry Posture** panel to the Internal tab
- surfaces request reference, source context, planning mode, and entry richness in one operator scan
- keeps operator workspace consolidation moving without schema or public-flow changes

## v2.5.9 — Brief Readiness Panel
- added a read-only Brief Readiness panel at the top of the Request tab
- surfaces trip, planning, and signal-coverage indicators before the operator works field-by-field
- preserves the existing editable request fields underneath
- no schema change
- no public theme change

## v2.6.5 — Stay Logistics Panel
- added a read-only Stay Logistics panel to the Internal tab
- surfaced trip timing, arrival posture, accommodation posture, and planning readiness in one operator scan surface
- kept the patch backend-only with no schema or public theme change

## v2.5.8 — Preference Signal Panel
- added a read-only Preference Signals panel at the top of the Preferences tab
- surfaces contact route, stay signals, and experience signals in one operator scan block
- preserves the existing editable preference fields underneath
- no schema change
- no public theme change

## v2.5.7 - List / Detail Consistency Polish
- aligned backend list wording with detail screen workflow labels
- list now shows operator-friendly status and priority labels
- source column now falls back safely instead of showing blank values
- owner column now shows "Unassigned" instead of an empty value
- follow-up column now mirrors queue language used on the detail screen
- no schema change
- no public theme change

## v2.6.8 — Coverage & Gaps Panel
- added a read-only Coverage & Gaps panel to the Internal tab
- surfaces missing brief coverage, missing workflow coverage, and an overall hand-off readiness posture in one scan-first block
- keeps the patch backend-only with no schema or public theme change



## v2.6.4 — Service Posture Panel
- added a read-only Service Posture panel to the Internal tab
- surfaces service intent, experience-specific signals, and planning continuity in one scan-first block
- keeps the patch backend-only with no schema or public theme change


## v2.6.3 — Contact Posture Panel
- added a read-only Contact Posture panel to the Internal tab
- surfaces preferred route, latest outreach posture, and the next communication move in one scan-first block
- keeps the patch backend-only with no schema or public theme change

## v2.6.1 — Operator Workspace Summary
- started the v2.6 operator workspace consolidation line
- added a unified read-only operator workspace summary panel to the Internal tab
- consolidated workflow posture, guest brief readiness, and preference depth into a single scan-first surface
- kept the patch backend-only with no schema or public theme change

## v2.5.6 — List Queue Snapshot
- added read-only queue snapshot cards to the backend inquiry list toolbar
- surfaces active, unassigned, needs-first-touch, due-today, and overdue counts
- preserves conservative list filters and introduces no schema change

## v2.5.4 — Stable Checkpoint
- added assignment / status continuity polish on the backend inquiry update screen
- improved owner, queue posture, next action, follow-up, and closure readability
- kept plugin-only scope with no schema change
- no public theme disruption introduced

## v2.5.3 — History Timeline Usability
- replaced plain history preview with a card-based timeline view
- preserved append-only internal note workflow
- improved operator scan speed for timeline entries

## v2.5.2 — Update Screen Polish
- upgraded the inquiry update header into a stronger operator summary surface
- improved quick action presentation
- refined backend form labels and screen structure

## v2.5.1 — List Hotfix
- simplified list filters to restore reliable backend inquiry list rendering
- avoided aggressive queue bucket definitions that could blank the list view

## v2.5.0 — Backend Queue Actions
- added quick workflow actions for assignment, contact, follow-up, reopen, and close states
- ensured quick actions append explicit system history entries

## v2.4.0 — Backend Detail Polish
- improved overview summaries and payload readability
- surfaced more operator-friendly list information

## v2.3.0 — Plan Bridge Standardization
- standardized `/plan` around `mykonosPlanBridge`
- tightened continuity between saved server response and frontend success state

## v2.2.0 — Concierge Workflow Patch
- added lifecycle workflow fields such as `last_contacted_at`, `closed_at`, and `closed_reason`
- expanded system history logging for key workflow transitions

## v2.1.0 — Operator Workflow Patch
- added inquiry priority
- added history/notes table and initial system notes
- added append-only internal note handling

## v2.0 / v41 integration line
- established the first real bridge between the public `/plan` flow and plugin-backed database persistence

## v2.6.6 - Occasion & Lifestyle Panel
- added a read-only **Occasion & Lifestyle** panel to the Internal tab
- surfaces celebration intent, dining posture, nightlife appetite, and special-moment signals
- keeps operator workspace consolidation moving without schema or public-flow changes
