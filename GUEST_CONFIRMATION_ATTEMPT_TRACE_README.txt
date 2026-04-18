Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, and guest confirmation email are already working correctly.

So instead of changing SMTP, schema, or inquiry workflow, this major step adds a lightweight persisted guest-confirmation attempt trace using the existing inquiry notes table and upgrades the Guest Email Posture panel to show that trace.

Verification
- submit a fresh /plan inquiry with a real test guest email
- backend inquiry is created normally
- operator email still arrives at mykonos@cabnet.app
- guest confirmation email still arrives at the submitted email address
- Inquiry Notes now includes a system note describing the guest-confirmation attempt result
- the Guest Email Posture panel now shows the latest saved attempt note and timestamp
