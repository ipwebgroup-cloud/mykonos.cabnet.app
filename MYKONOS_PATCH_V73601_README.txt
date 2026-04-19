MYKONOS v7.36.01 Confidence Strip Direct Hotfix

Purpose
- Fix the live parse error in:
  plugins/cabnet/mykonosinquiry/controllers/inquiries/_confidence_strip.htm

The broken syntax is:
- True:
- False:

The correct PHP syntax is:
- true =>
- false =>

Included
- MYKONOS_FIX_CONFIDENCE_STRIP.php

Recommended use
1. Upload this rooted package preserving:
   mykonos.cabnet.app/...
2. Make sure MYKONOS_FIX_CONFIDENCE_STRIP.php sits in the real project root that contains /plugins.
3. Run one of these:

Browser:
- https://your-domain/MYKONOS_FIX_CONFIDENCE_STRIP.php

CLI:
- php /full/path/to/MYKONOS_FIX_CONFIDENCE_STRIP.php

4. Clear cache:
- php artisan cache:clear

Manual fallback
Edit:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_confidence_strip.htm

Replace:
- True:
with:
- true =>

Replace:
- False:
with:
- false =>

Notes
- No schema change
- No plugin refresh required
- No theme import required
- No /plan change
