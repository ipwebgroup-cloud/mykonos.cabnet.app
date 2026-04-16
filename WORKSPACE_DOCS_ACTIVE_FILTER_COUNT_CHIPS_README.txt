Workspace Docs Active Filter Count Chips v6.72.00

This patch adds a compact active-filter count chip strip near the top of the Workspace Docs page.
It reads the current help route query string and surfaces readable chips for active search or filter context when present.

No schema change.
No plugin refresh required.
Recommended after upload: php artisan cache:clear
