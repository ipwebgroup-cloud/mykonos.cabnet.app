# Mykonos Inquiry Plugin v3.0.0 Communication Workspace

## Package
- `mykonos-v3.0.0-communication-workspace-rooted-patch.zip`

## What changed
- added a new **Communication** tab to the backend inquiry update screen
- added **Communication Workspace** for route, tone, readiness, and the safest next guest-facing move
- added **Next Reply Blueprint** so operators can shape a disciplined response structure without rescanning every tab
- added **Reply Risk Guardrails** to keep ownership, pacing, channel choice, and promise level continuity-safe

## Why this patch matters
The update screen already had strong scan-first guidance for command posture, action posture, internal continuity, history, and raw payload review.

The next safe major step was to create a dedicated communication layer so operators can move from queue triage and action posture into a guest-facing reply strategy without drifting into generic or over-committed messaging.

## Install
1. Upload the patch contents so paths merge into the live project starting at:
   `mykonos.cabnet.app/...`
2. Open backend → **Mykonos Inquiries**
3. Open an inquiry record
4. Verify a new **Communication** tab appears between **Action** and **Request**

## Verify
- the **Communication** tab renders without form errors
- **Communication Workspace** shows route / tone / timing posture
- **Next Reply Blueprint** shows structured reply guidance
- **Reply Risk Guardrails** shows continuity-safe warnings based on the record state

## Notes
- no schema change
- no public theme or `/plan` change
- no list-filter expansion
- backend-only operator workflow milestone
