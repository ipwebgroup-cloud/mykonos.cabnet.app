MYKONOS v7.23.02 boolean-key strip hotfix

Why this patch exists
- The backend inquiry record is failing to render because some strip partials use invalid PHP array syntax:
  True:  [...]
  False: [...]
- PHP requires:
  true => [...]
  false => [...]

What this patch does
- Adds a one-time PHP patcher at project root:
  MYKONOS_PATCH_V72302_APPLY.php
- The patcher scans:
  plugins/cabnet/mykonosinquiry/controllers/inquiries/*.htm
- It replaces invalid boolean-style keys safely and creates backup copies:
  *.bak-v72302

How to run
1. Upload this rooted patch preserving paths under mykonos.cabnet.app/.
2. In the browser open:
   https://your-domain/MYKONOS_PATCH_V72302_APPLY.php
   or run with PHP CLI from project root:
   php MYKONOS_PATCH_V72302_APPLY.php
3. Confirm changed files are reported.
4. Clear cache:
   php artisan cache:clear
5. Reload the backend inquiry detail page.

Scope
- No schema change
- No plugin refresh required
- No theme import required
- No /plan behavior change
- No queue workflow change
