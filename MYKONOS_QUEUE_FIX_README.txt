Mykonos Inquiry Queue render/layout fix patch

Purpose:
- restore a safer inquiry list filter baseline
- move the large quick-start guidance block out of the toolbar
- keep the toolbar focused on actions + the compact scan note
- preserve rooted file paths for direct replacement

Changed files:
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/config_list.yaml
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_list_toolbar.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/_queue_quickstart_panel.htm
- mykonos.cabnet.app/plugins/cabnet/mykonosinquiry/controllers/inquiries/index.htm

After upload:
- php artisan cache:clear

Verify:
- Backend -> Mykonos Inquiries -> Inquiry Queue
- list area renders again
- operator quick-start panel appears above the list, not squeezed inside the toolbar
- search and action buttons stay aligned normally
