# MYKONOS_PLUGIN_HANDOFF.md

## Latest applied patch line

Latest known rooted patch prepared for deployment:

- `v6.85.00 branded HTML email layouts`
- plugin tracking `2.4.23`

This patch stays plugin-only and does not touch `/plan` storage, schema, or queue logic.
It keeps the existing operator notification email and guest confirmation flow, but upgrades both into cleaner branded HTML layouts while preserving text alternatives.

## Deployment note

For this patch, upload the rooted files and then run:

- `php artisan cache:clear`

No schema change is introduced and no plugin refresh is required for this step.

Then verify:
- submit a new `/plan` inquiry
- backend inquiry is created normally
- operator email still arrives at `mykonos@cabnet.app`
- guest confirmation email still arrives at the submitted guest email address
- both emails now render as cleaner branded HTML in Roundcube and Gmail
