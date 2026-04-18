Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, guest-confirmation attempt trace, operator email summary card, concierge-response checklist, reply-draft framing strip, and internal next-action strip are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact follow-up timing strip directly to the inquiry record so operators can compare next action with timing posture from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- a Follow-Up Timing strip appears in the inquiry form
- the strip shows a primary timing action and timing posture pills
- Internal Next Action, Reply Draft Framing, Concierge Response Checklist, Operator Email Summary, and Guest Email Posture remain visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
