MYKONOS PATCH V7.23.01

Title: Request Completeness Parse Hotfix

Scope:
- backend-only
- render hotfix
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change

Issue fixed:
- PHP parse error in:
  plugins/cabnet/mykonosinquiry/controllers/inquiries/_request_completeness_strip.htm
- Original code used invalid array keys:
  True:
  False:
- Fixed to valid PHP boolean keys:
  true =>
  false =>

Install:
1. Upload the rooted file preserving paths.
2. Clear backend/cache if needed:
   php artisan cache:clear

Verify:
1. Open backend inquiry detail.
2. Confirm the page renders.
3. Confirm the Request Completeness strip loads without the parse error.
