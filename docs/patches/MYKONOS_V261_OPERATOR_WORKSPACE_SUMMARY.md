# Mykonos v2.6.1 Operator Workspace Summary Patch

## Scope
Backend-only operator workspace consolidation starter patch.

## What changed
- added a new **Operator Workspace Summary** partial to the inquiry update screen
- mounted the panel at the top of the **Internal** tab
- consolidated workflow posture, brief readiness, and preference depth into one read-only scan surface
- updated the changelog and plugin version tracking for the `v2.6.x` line

## Why this patch matters
The previous line added several useful read-only panels across multiple tabs. This patch starts the `v2.6` major line by giving operators a single summary panel that helps them understand ownership, queue posture, brief richness, and preference density before drilling into the detailed tabs.

## Safety
- no schema change
- no public theme change
- no list filter change
- no persistence logic change
