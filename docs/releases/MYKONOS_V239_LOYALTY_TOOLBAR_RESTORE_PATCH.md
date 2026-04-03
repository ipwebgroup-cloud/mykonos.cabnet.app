# Mykonos Plugin v2.3.9 Loyalty Toolbar Restore Patch

## Package
- `cabnet-mykonosinquiry-plugin-v2.3.9-loyalty-toolbar-restore-public-html-rooted.zip`

## What changed
- restored the missing `controllers/loyaltyrecords/_toolbar.htm` partial
- fixes the backend Loyalty Continuity list page crash caused by the missing toolbar partial
- keeps the current loyalty workspace render templates and guardrails intact
- no schema change
- no theme change

## Expected result
- the Loyalty Continuity list page should render instead of throwing a partial-not-found error
- the page should show the standard create button for new loyalty records

## Root handoff
- `MYKONOS_PLUGIN_HANDOFF.md` remains at the project root for continuity if the chat is interrupted
