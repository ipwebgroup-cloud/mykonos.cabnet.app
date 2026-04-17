Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling. The current live mail setup already sends both the operator notification and the guest confirmation correctly.

So instead of changing SMTP or queue behavior, this major step upgrades both emails into cleaner branded HTML layouts while preserving plain text alternatives.
