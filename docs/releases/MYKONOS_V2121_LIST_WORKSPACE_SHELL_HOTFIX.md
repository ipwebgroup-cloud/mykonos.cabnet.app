# Mykonos v2.12.1 — List Workspace Shell Hotfix

## Why this hotfix exists
The v2.12.0 list workspace shell introduced a backend render error on the inquiry list page because `_list_toolbar.htm` used `makePartial(...)` instead of the backend-controller-safe `$this->makePartial(...)`.

## What changed
- fixed partial rendering calls inside `plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_toolbar.htm`
- no schema change
- no list filter change
- no public `/plan` change
- no queue logic change

## Verify
1. Open backend → **Mykonos Inquiries**
2. Confirm the list page renders normally
3. Confirm the workspace shell sections still expand/collapse
4. Confirm queue boards and queue-to-record bridge still render
