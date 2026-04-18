Current state assessment

This major update stays on the safe line established from the real v41 integration point. The live /plan flow, backend save, operator notification email, and guest confirmation email are already working correctly.

So instead of changing SMTP or inquiry workflow, this major step moves both branded HTML emails into dedicated view template files so future email polish becomes safer and easier.

Verification
- submit a fresh /plan inquiry with a real test guest email
- backend inquiry is created normally
- operator email still arrives at mykonos@cabnet.app
- guest confirmation email still arrives at the submitted email address
- both emails still render correctly after the template split
