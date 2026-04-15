# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.56.00 dual-owner posture cues across inquiry and loyalty records`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It adds compact owner-alignment guidance strips to the inquiry and loyalty update screens so operators can immediately see whether queue ownership and continuity ownership are aligned, split, or still unclear.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue -> open an inquiry that links to continuity
- Backend -> Loyalty Continuity -> open a continuity record with a source inquiry
- both record screens now show an owner-alignment strip above the main summary shell
- existing form fields, actions, notes, and workflow behavior remain unchanged

## Why this is a safe major step

This is a meaningful operator-facing upgrade because it:
- reduces handoff ambiguity
- keeps queue and continuity ownership visible without opening deeper history
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this ownership-visibility pass, the next strong step should be one of:
- add lightweight stale-timing cues when queue follow-up and continuity review have both drifted
- add compact owner mismatch cues on seeded create flows when a source inquiry is preloaded
- improve bridge help anchors so record-screen guidance deep-links directly into the right docs section
