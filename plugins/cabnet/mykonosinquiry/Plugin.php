<?php namespace Cabnet\MykonosInquiry;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Mykonos Inquiry',
            'description' => 'Stores Mykonos plan requests in the database and exposes them in the backend.',
            'author' => 'CABnet',
            'icon' => 'icon-envelope-open',
        ];
    }

    public function registerComponents(): array
    {
        return [
            \Cabnet\MykonosInquiry\Components\PlanBridge::class => 'mykonosPlanBridge',
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'cabnet.mykonosinquiry.manage_inquiries' => [
                'tab' => 'Mykonos Inquiry',
                'label' => 'Manage inquiries',
            ],
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'mykonosinquiry' => [
                'label' => 'Mykonos Inquiries',
                'url' => Backend::url('cabnet/mykonosinquiry/inquiries'),
                'icon' => 'icon-envelope-open',
                'permissions' => ['cabnet.mykonosinquiry.manage_inquiries'],
                'order' => 500,
            ],
        ];
    }
}
