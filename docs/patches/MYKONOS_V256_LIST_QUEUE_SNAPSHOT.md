# Mykonos Inquiry Platform v2.5.6 — List Queue Snapshot

## Summary

This patch adds a read-only queue snapshot to the backend inquiry list toolbar so operators can see the current workload posture without changing the conservative list filter baseline.

## Included
- active queue count
- unassigned inquiry count
- needs first touch count
- due today count
- overdue count

## Safety
- no schema change
- no public theme change
- no list filter scope expansion
- plugin-only backend usability improvement
