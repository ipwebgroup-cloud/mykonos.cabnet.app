Current state assessment

This major update stays on the safe line established from the real v41 integration point: the public /plan flow remains plugin-backed and database-backed, and future work should continue from that bridge rather than drifting into theme-only internal request handling. The backend line already evolved through operator workflow, concierge lifecycle, backend detail polish, queue actions, list safety, and the newer operator guidance layers.

So instead of risking /plan, schema, or queue logic, this major step upgrades Workspace Docs with a compact quick glossary block so operators can decode the most-used bridge terms instantly on the docs page.

Verification
- Backend -> Workspace Docs
- a compact Quick glossary block appears near the top of the page
- opening docs from queue, loyalty, and record-screen help updates the glossary summary
- quick-return chips, route-memory, and bridge-state legend still work
- docs search, glossary, and return actions remain unchanged
