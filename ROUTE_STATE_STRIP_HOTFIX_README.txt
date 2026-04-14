Route-state strip hotfix

Fixes PHP partial parse failure caused by:
use Backend;
inside backend partial .htm files.

Removed the non-compound use statement from:
- plugins/cabnet/mykonosinquiry/controllers/inquiries/_route_state_strip.htm
- plugins/cabnet/mykonosinquiry/controllers/loyaltyrecords/_route_state_strip.htm

After upload run:
php artisan cache:clear
