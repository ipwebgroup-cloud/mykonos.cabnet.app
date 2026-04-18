Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, guest-confirmation attempt trace, operator email summary card, concierge-response checklist, reply-draft framing strip, internal next-action strip, follow-up timing strip, follow-up ownership strip, follow-up readiness recap, internal escalation strip, internal urgency strip, concierge-handoff strip, partner-routing strip, proposal-readiness strip, proposal-delivery strip, reply-channel strip, contact-quality strip, guest-profile strip, stay-profile strip, service-shape strip, and request-completeness strip are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact response-quality strip directly to the inquiry record so operators can compare request completeness and response quality posture from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- a Response Quality strip appears in the inquiry form
- the strip shows a primary quality posture and quality signals
- Request Completeness, Service Shape, Stay Profile, Guest Profile, Contact Quality, Reply Channel, Proposal Delivery, Proposal Readiness, Partner Routing, Concierge Handoff, Internal Urgency, Internal Escalation, Follow-Up Readiness Recap, Follow-Up Ownership, Follow-Up Timing, Internal Next Action, Reply Draft Framing, Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
