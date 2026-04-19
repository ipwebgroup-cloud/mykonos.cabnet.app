MYKONOS PATCH V72500

Patch line
- v7.25.00 inquiry record proceed-or-pause recommendation strip

Scope
- backend only
- render only
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Files included
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_proceed_or_pause_recommendation_strip.htm
- plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml
- README.md
- CHANGELOG.md
- MYKONOS_PLUGIN_HANDOFF.md
- MYKONOS_CONTINUE_PROMPT.md

Verify
- open a backend inquiry record
- confirm Proceed or Pause Recommendation appears after Minimum Evidence to Proceed
- confirm it shows a plain recommendation, do-now guidance, avoid-now guidance, and operator cue
