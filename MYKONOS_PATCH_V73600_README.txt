MYKONOS PATCH V73600

Patch: v7.36.00 inquiry record not ready after one fix strip
Scope: backend-only, render-only inquiry detail enhancement

What changed
- added Not Ready After One Fix strip
- wired the new strip into inquiry fields.yaml

Behavior
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Install
1. Upload the rooted files preserving mykonos.cabnet.app/...
2. Run: php artisan cache:clear

Verify
- Open Backend -> Mykonos Inquiries -> any inquiry
- Confirm Not Ready After One Fix appears after Ready After One Fix
- Confirm it explains the shortest two-step recovery path when one fix alone is not enough
