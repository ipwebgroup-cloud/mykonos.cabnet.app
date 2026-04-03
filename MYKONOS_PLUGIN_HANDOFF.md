# MYKONOS PLUGIN HANDOFF

## Current line
- Project: `mykonos.cabnet.app`
- Plugin: `plugins/cabnet/mykonosinquiry`
- Current patch line delivered in chat: **v2.3.8 loyalty workspace render fix**
- Archive root convention: zip contents begin with `mykonos.cabnet.app/` so extraction starts from `/home/cabnet/public_html/`

## Stable intent
The stable source-of-truth direction remains the database-backed inquiry workflow introduced in the v41 integration line. Public `/plan` saves through the plugin and backend work should continue from that plugin-first flow.

## What has been stabilized in this chat
- loyalty inquiry partial crashes were guarded
- loyalty inquiry panels now avoid hard failure when loyalty tables are absent or the workspace is only partially active
- loyalty routing / readiness / guardrail messaging was added on the inquiry side
- loyalty workspace blank backend body was fixed by adding the missing controller render templates

## Current expectation after v2.3.8
- **Inquiry Queue** should render
- inquiry update pages should render
- **Loyalty Continuity** should no longer show a blank body
- no destructive refresh should be used casually on the live plugin line

## Next safest step
- continue with plugin-only backend polish
- keep schema untouched unless explicitly needed
- preserve the live inquiry queue and public `/plan` flow
- prefer conservative OctoberCMS controller/view completions over risky structural rewrites
