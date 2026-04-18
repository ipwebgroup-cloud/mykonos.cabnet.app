Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, guest confirmation email, and guest-confirmation attempt trace are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a compact operator email summary card directly to the inquiry record so operators can compare mailbox target, guest trace, and latest internal response context from one backend screen.

Verification
- open a real inquiry in Backend -> Inquiries
- an Operator Email Summary card appears in the inquiry form
- the card shows mailbox target, guest contact basics, service focus, and latest internal note context
- Guest Email Posture remains visible and unchanged
- no /plan behavior, queue logic, or email sending logic changes
