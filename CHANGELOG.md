## v3.7.1 — Recovery Workspace Payload Hotfix
- fixes an **array to string conversion** crash on the Recovery tab when `payload_json` is already hydrated as an array or object on the inquiry model
- hardens the Recovery Workspace payload handling so the panel can safely detect raw payload availability without breaking the backend update screen
- keeps the update backend-only with no schema, list, quick-action, or public `/plan` change

## v3.6.0 — Handoff Workspace
- added a dedicated **Handoff** tab to the inquiry update screen
- introduced **Handoff Workspace**, **Handoff Packet Blueprint**, and **Handoff Risk Guardrails** panels
- gives operators a backend-only space to transfer active, reopened, or paused inquiries with explicit continuity packet discipline without touching public `/plan`, schema, or list stability

## v3.5.0 — Reopen Workspace
- adds a new **Reopen** tab to the backend inquiry update screen
- introduces a composite **Reopen Workspace** panel for disciplined reactivation, continuity rebuilding, and second-cycle ownership clarity
- adds **Reactivation Blueprint** guidance so operators can revive paused or closed records without losing source trail, guest mission, timing anchors, or operator continuity
- adds **Reopen Risk Guardrails** to prevent stale assumptions, soft ownership, hidden blockers, and fragile hand-off posture during reactivation
- keeps the update backend-only with no schema, backend list, quick-action, or public `/plan` change

## v3.4.0 — Closure Workspace
- adds a new **Closure** tab to the backend inquiry update screen
- introduces a composite **Closure Workspace** panel for close / lost / pause / reopen posture before momentum fades into ambiguity
- adds **Closure Decision Blueprint** guidance so operators capture the outcome, reason, and reopen path explicitly instead of letting records drift into informal closure
- adds **Closure Risk Guardrails** to protect ownership, continuity, checkpoint visibility, and future reopen readability
- keeps the update backend-only with no schema, backend list, quick-action, or public `/plan` change

## v3.3.0 — Confirmation Workspace
- adds a new **Confirmation** tab to the backend inquiry update screen
- introduces a composite **Confirmation Workspace** panel for commitment shaping and disciplined pre-confirmation handling
- adds **Commitment Lock Blueprint** guidance so operators move into confirmation language without losing scope, timing, or continuity anchors
- adds **Confirmation Risk Guardrails** to prevent over-confirming, ownership blur, and fragile reopen conditions
- keeps the update backend-only with no schema, backend list, quick-action, or public `/plan` change

## v3.2.0 — Fulfillment Workspace
- adds a new **Fulfillment** tab to the backend inquiry update screen
- introduces a composite **Fulfillment Workspace** panel for operational sequencing and execution-readiness posture
- adds **Execution Readiness Blueprint** guidance so operators move from commercial shaping into disciplined operational planning
- adds **Fulfillment Risk Guardrails** to prevent assumption-heavy delivery language, weak hand-off cues, and invisible execution drift
- keeps the update backend-only with no schema, backend list, quick-action, or public `/plan` change

## v3.1.0 — Proposal Workspace
- adds a new **Proposal** tab to the backend inquiry update screen
- introduces a composite **Proposal Workspace** panel for offer shaping and commercial posture
- adds **Offer Shape Blueprint** guidance so operators can structure the next premium offer without breaking continuity
- adds **Proposal Risk Guardrails** to prevent over-promising, blurred offer logic, and avoidable commercial drift
- keeps the update backend-only with no schema, backend list, quick-action, or public `/plan` change

## v3.0.0 — Communication Workspace
- adds a new **Communication** tab to the backend inquiry update screen
- introduces a composite **Communication Workspace** panel for route, tone, readiness, and the safest next guest-facing move
- adds **Next Reply Blueprint** guidance so operators can shape a continuity-led response without reopening every tab by habit
- adds **Reply Risk Guardrails** to prevent premature promises, ownership blur, channel mismatch, and over-packaging before anchors are confirmed
- keeps the update backend-only with no schema, backend list, quick-action, or public `/plan` change

## v2.9.0 — Action Workspace
- adds a new **Action** tab to the backend inquiry update screen
- introduces a composite **Operator Action Workspace** panel for record-level next-move control across queue posture, guest coverage, and continuity
- adds **Next Move Execution** guidance for route, message goal, must-include points, and what to avoid on the next touch
- adds **Record Transition Guardrails** to keep clarification, proposal shaping, confirmation posture, and closure/reopen decisions disciplined
- keeps the update backend-only with no schema, list filter, quick-action, or public `/plan` change

## v2.8.0 — Queue Command Board
- upgrades the backend inquiry list page into a stronger operator triage surface
- expands the list toolbar into a read-only **Queue Command Board** with live queue metrics and headline posture
- adds **Live Triage Lanes** so operators can jump directly into unassigned, overdue, due-today, and proposal-window records
- adds an **Operator Triage Playbook** with queue-first routing guidance before opening individual inquiries
- keeps the update backend-only with no schema, public `/plan`, quick-action, or stable filter regression risk

## v2.7.0 — Operator Command Deck
- added a new **Command** tab to the backend inquiry update screen
- introduced a composite **Operator Command Deck** panel for queue posture, guest readiness, commercial clarity, and safest next action
- added **Next Guest Touch Blueprint** guidance for response route, tone, message goal, and highest-value clarifications
- added **Handoff Packet Readiness** checks so assignment, notes, source trail, and closure context are easier to trust during hand-off or reopen review
- kept the update backend-only with no schema, list, quick-action, or public `/plan` change

## v2.6.33 — Source Continuity Panel
- added a read-only **Source Continuity** panel to the Source tab
- surfaces whether source type, requested mode, source title/slug, URL, and request reference are preserved clearly enough for campaign traceability and operator hand-off
- keeps the patch backend-only with no schema, list, quick-action, or public `/plan` flow change

## v2.6.32 — Payload Carryover Gaps Panel
- added a read-only **Payload Carryover Gaps** panel to the Raw tab
- surfaces which preference and logistics cues still live only in payload instead of the structured operator record
- helps operators lift important planning nuance into working summary or history before hand-off, reopen, or closure
- keeps the patch backend-only with no schema, list, quick-action, or public `/plan` flow change

## v2.6.31 — Reopen Recovery Cues Panel
- added a read-only **Reopen Recovery Cues** panel to the Raw tab
- surfaces whether the inquiry can be safely reopened or handed off later without depending too heavily on memory or raw JSON
- keeps the patch backend-only with no schema, list, quick-action, or public-flow change


## v2.6.30 — Payload Alignment Signals Panel
- added a read-only **Payload Alignment Signals** panel to the Raw tab
- compares normalized inquiry fields against the saved payload so operators can spot drift before using raw JSON as a fallback continuity source
- keeps the patch backend-only with no schema, list, quick-action, or public-flow change


## v2.6.29 — Raw Payload Framing Panel
- added a read-only **Raw Payload Framing** panel to the Raw tab
- helps operators interpret the saved payload as a continuity fallback, source check, and reopen reference before scanning the raw JSON block
- keeps the patch backend-only with no schema, list, quick-action, or public-flow change


## v2.6.28 — History Note Framing Panel
- added a read-only **History Note Framing** panel to the History tab
- bridges the gap between timeline scanning and append-only note entry so operators record cleaner continuity notes
- keeps the patch backend-only with no schema, list, quick-action, or public-flow change


## v2.6.27 — Working Notes Posture Panel
- added a read-only **Working Notes Posture** panel to the Internal tab
- surfaces what the rolling note should preserve for continuity, where the current note is thin or overloaded, and the safest note-writing move before editing working notes
- keeps the patch backend-only with no schema change, no backend list change, and no public `/plan` flow change

## v2.6.26 — Closure Posture Panel
- adds a read-only **Closure Posture** panel to the Internal tab near the closure fields
- surfaces whether the record is truly ready to close, what closure context is still missing, and the safest operator move before using close or reopen actions
- keeps the patch backend-only with no schema change, no list change, and no public `/plan` flow change


## v2.6.25 — Handoff Focus Restoration
- restores the read-only **Handoff Focus** panel on the Internal tab after confirming the partial still exists in the repo but is not currently wired into the stabilized inquiry form
- surfaces guest focus, queue checkpoint, and current working picture in one operator scan block before editing the detailed internal fields
- keeps the patch backend-only with no schema change, no list change, and no public `/plan` flow change


## v2.6.24 — Operator Workspace Activation Alignment
- safely activates the remaining read-only Internal-tab panels that already exist in the repo but were not yet wired into the current inquiry form
- brings **Risk & Sensitivity**, **Commercial Posture**, **Decision Posture**, **Proposal Readiness**, **Fulfillment Readiness**, **Working Summary Framing**, and **Guest Confidence Signals** into the live operator workspace
- keeps the patch backend-only with no schema change and no public `/plan` flow change


## v2.6.21 — Clarification Targets Panel
- added a read-only **Clarification Targets** panel to the Internal tab
- surfaces the highest-value missing facts, continuity-first questions, and what to confirm on the next guest touch before over-shaping the reply or package
- keeps the patch backend-only with no schema or public-flow change


## v2.6.20 — Reply Tone Guidance Activation
- safely activates the read-only **Reply Tone Guidance** panel on the Internal tab
- surfaces the safest reply tone, pacing, contact route, and guest-facing response shape
- keeps operator workspace consolidation moving without schema or public-flow changes

## v2.6.19 — Response Packaging Activation
- reintroduced the read-only **Response Packaging** panel on the Internal tab
- surfaces what should go into the next guest-facing package, what still needs confirmation, and whether the inquiry is ready for a starter package or fuller shaping
- keeps the patch backend-only with no schema or public-flow change

## v2.6.17 — Reply Tone Guidance Panel
- added a read-only **Reply Tone Guidance** panel to the Internal tab
- surfaces the safest tone, pacing, route, and reply shape for the next guest-facing message
- keeps operator workspace consolidation moving without schema or public-flow changes

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

## v2.6.15 — Fulfillment Readiness Panel
- added a read-only **Fulfillment Readiness** panel to the Internal tab
- surfaces execution readiness, sourcing posture, and what still needs confirmation before concrete supplier or itinerary shaping
- keeps operator workspace consolidation moving without schema or public-flow changes

## v2.6.16 — Working Summary Framing Panel
- added a read-only **Working Summary Framing** panel to the Internal tab
- surfaces the safest summary anchors, write checks, and hand-off framing guidance before updating operator notes
- keeps operator workspace consolidation moving without schema or public-flow changes

## v2.6.21 — Clarification Targets Panel
- added a read-only **Clarification Targets** panel to the Internal tab
- surfaces the highest-value missing facts, continuity-first questions, and the safest next clarification targets before over-shaping a reply

## v2.6.22 — Confirmation Blockers Panel
- added a read-only **Confirmation Blockers** panel to the Internal tab
- surfaces the concrete blockers that still stand between the current inquiry and a confident confirmation-style move
- keeps operator workspace consolidation moving without schema or public-flow changes
## v2.6.23 — Guest Confidence Signals Panel
- added a read-only **Guest Confidence Signals** panel to the Internal tab
- surfaces ownership clarity, continuity cueing, and the safest next confidence-building move before the next guest touch
- keeps operator workspace consolidation moving without schema or public-flow changes

## v3.1.0 — Proposal Workspace
- added a dedicated **Proposal** tab to the inquiry update screen
- introduced **Proposal Workspace**, **Offer Shape Blueprint**, and **Proposal Risk Guardrails** panels
- gives operators a backend-only space to shape premium starter offers and proposal follow-up without touching public `/plan`, schema, or list stability

## v3.2.0 — Fulfillment Workspace
- added a dedicated **Fulfillment** tab to the inquiry update screen
- introduced **Fulfillment Workspace**, **Execution Readiness Blueprint**, and **Fulfillment Risk Guardrails** panels
- gives operators a backend-only space to move from proposal posture into execution readiness without touching public `/plan`, schema, or list stability

## v3.3.0 — Confirmation Workspace
- added a dedicated **Confirmation** tab to the inquiry update screen
- introduced **Confirmation Workspace**, **Commitment Lock Blueprint**, and **Confirmation Risk Guardrails** panels
- gives operators a backend-only space to move from fulfillment posture into disciplined commitment language without touching public `/plan`, schema, or list stability

## v3.7.0 — Recovery Workspace
- added a dedicated **Recovery** tab to the inquiry update screen
- introduced **Recovery Workspace**, **Continuity Rebuild Blueprint**, and **Recovery Risk Guardrails** panels
- gives operators a backend-only space to rebuild fragmented or stalled records before reopening, handing off, or restarting guest-facing motion

## v3.7.1 — Recovery Workspace Payload Hotfix
- hardened **Recovery Workspace** handling for array-backed `payload_json` values
- restored stable rendering on the inquiry update screen when raw payload is hydrated as structured data

## v3.8.0 — Planning Workspace
- added a dedicated **Planning** tab to the inquiry update screen
- introduced **Planning Workspace**, **Next Stage Map Blueprint**, and **Planning Risk Guardrails** panels
- gives operators a backend-only space to sequence the next operator phase after recovery, clarification, or continuity repair without touching public `/plan`, schema, or list stability
