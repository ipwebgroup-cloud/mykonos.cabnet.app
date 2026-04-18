Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, guest-confirmation attempt trace, operator email summary card, concierge-response checklist, and reply-draft framing strip are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact internal next-action strip directly to the inquiry record so operators can move from draft framing into a clearer operational next step from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- an Internal Next Action strip appears in the inquiry form
- the strip shows a primary action and supporting action pills
- Reply Draft Framing, Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
