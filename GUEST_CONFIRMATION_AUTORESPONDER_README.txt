Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling. The current live mail setup already sends operator notifications correctly to mykonos@cabnet.app.

So instead of changing SMTP again, this major step adds the missing guest confirmation autoresponder after successful /plan submission.

Verification
- submit a fresh /plan inquiry with a real test guest email
- backend inquiry is created normally
- operator email still arrives at mykonos@cabnet.app
- guest confirmation email now arrives at the submitted email address
- reply-to on the guest message points back to the operator mailbox
