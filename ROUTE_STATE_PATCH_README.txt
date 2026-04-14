Mykonos v6.43.00 route-state summary strips for queue and loyalty

Install
1. Extract this rooted patch from /home/cabnet/public_html/
2. Run: php artisan cache:clear

No schema change
No plugin refresh required
No theme import required

Verify
- Backend -> Inquiry Queue shows a compact route-state strip above the list
- Backend -> Loyalty Continuity shows a compact route-state strip above the list
- active search/filter posture is summarized when present
- queue-to-loyalty posture counts are visible from the queue strip
- search, filters, and row actions still render normally
