Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, guest-confirmation attempt trace, and operator email summary card are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact concierge-response checklist directly to the inquiry record so operators can move from email context into concrete first-reply handling from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- a Concierge Response Checklist strip appears in the inquiry form
- the strip shows readiness cards for identity, dates, guest count/service scope, and first-reply angle
- Guest Email Posture and Operator Email Summary remain visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
