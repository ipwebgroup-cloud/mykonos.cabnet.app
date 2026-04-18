Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, and guest confirmation email are already working correctly.

So instead of changing SMTP or inquiry workflow, this major step adds a backend-visible guest-email posture panel to the inquiry record so operators can judge confirmation eligibility and recipient readiness from the record itself.

Verification
- open a real inquiry in Backend -> Inquiries
- a Guest Email Posture panel appears in the inquiry form
- valid guest emails show positive eligibility posture
- missing or invalid guest emails show warning posture
- no /plan behavior, queue logic, or email sending logic changes
