# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.41.75 inquiry queue row wording compression patch`
- plugin tracking `2.4.23`

This patch stays backend-only and does not touch `/plan`.
It compresses the visible Inquiry Queue row wording in the default queue cells so operators can scan the row faster without losing status, priority, loyalty link state, owner, or follow-up signals.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- Backend -> Inquiry Queue
- queue row cells read a little tighter
- the same status, priority, loyalty, owner, and follow-up signals still appear
- list behavior remains unchanged
