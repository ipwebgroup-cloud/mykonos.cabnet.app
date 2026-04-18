Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, guest-confirmation attempt trace, operator email summary card, concierge-response checklist, reply-draft framing strip, internal next-action strip, and follow-up timing strip are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact follow-up ownership strip directly to the inquiry record so operators can compare next action, timing posture, and ownership posture from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- a Follow-Up Ownership strip appears in the inquiry form
- the strip shows a primary ownership posture and ownership signals
- Follow-Up Timing, Internal Next Action, Reply Draft Framing, Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
