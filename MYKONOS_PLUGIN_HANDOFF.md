# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.86.00 dedicated email view templates`
- plugin tracking `2.4.23`

This patch stays plugin-only and does not touch `/plan` storage, schema, or queue logic.
It keeps the existing operator notification email and guest confirmation flow working, but moves both branded HTML layouts into dedicated view template files so future email polish can be done without reopening the inquiry manager logic.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- submit a new `/plan` inquiry
- backend inquiry is created normally
- operator email still arrives at `mykonos@cabnet.app`
- guest confirmation email still arrives at the submitted guest email address
- both emails still render correctly after the view-file split

## Why this is a safe major step

This is a meaningful maintainability upgrade because it:
- keeps email presentation separate from core inquiry handling
- preserves the working SMTP and autoresponder flow
- keeps the live /plan bridge untouched
- keeps database and workflow behavior untouched
- stays plugin-only and render-safe

## Safest next step

After this template split, the next strong step should be one of:
- add a backend-visible flag showing whether guest confirmation was attempted
- add lighter summary cards and stronger grouping to the operator email view
- add a more guest-facing hospitality tone to the guest confirmation view
