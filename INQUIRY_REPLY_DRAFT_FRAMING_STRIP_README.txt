Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, guest-confirmation attempt trace, operator email summary card, and concierge-response checklist are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact reply-draft framing strip directly to the inquiry record so operators can move from checklist readiness into a clearer first-response structure from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- a Reply Draft Framing strip appears in the inquiry form
- the strip shows opening, availability angle, clarifying bridge, and closing direction blocks
- Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
