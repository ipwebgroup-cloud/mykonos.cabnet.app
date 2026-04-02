# Changelog

## v2.5.6 — Stable Checkpoint
- consolidates the current safe operator workflow line
- includes list queue snapshot visibility above the backend inquiry list
- keeps conservative list filtering and introduces no schema change
- intended as the current production checkpoint for inquiry operations

## v2.5.6 — List Queue Snapshot
- added read-only queue snapshot cards to the backend inquiry list toolbar
- surfaces active, unassigned, needs-first-touch, due-today, and overdue counts
- preserves conservative list filters and introduces no schema change

## v2.5.5.3 — History Partial Restore Hotfix
- restored missing `_history_timeline.htm` backend partial
- resolved inquiry update screen failure caused by missing history partial

## v2.5.5.2 — Workflow Continuity Hotfix
- fixed undefined variable usage in workflow continuity partial
- restored backend inquiry update screen rendering

## v2.5.5.1 — Follow-up Queue Hotfix
- fixed parse error caused by unescaped apostrophe in follow-up guidance text
- no behavior change beyond syntax correction

## v2.5.5 — Follow-up Queue Clarity
- added explicit follow-up queue states to the inquiry update surface
- improved follow-up posture and next-action guidance for operators

## v2.5.4 — Stable Checkpoint
- added assignment / status continuity polish on the backend inquiry update screen
- improved owner, queue posture, next action, follow-up, and closure readability
- kept plugin-only scope with no schema change
- no public theme disruption introduced

## v2.5.3 — History Timeline Usability
- replaced plain history preview with a card-based timeline view
- preserved append-only internal note workflow
- improved operator scan speed for timeline entries
