<?php namespace Cabnet\MykonosInquiry;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name'        => 'Mykonos Inquiry',
            'description' => 'Database-backed inquiry intake, operator workflow, and loyalty continuity workspace for the Mykonos Cabnet platform.',
            'author'      => 'CABnet',
            'icon'        => 'icon-diamond',
        ];
    }

    public function registerComponents(): array
    {
        return [
            \Cabnet\MykonosInquiry\Components\MykonosPlanBridge::class => 'mykonosPlanBridge',
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'cabnet.mykonosinquiry.manage_inquiries' => [
                'tab'   => 'Mykonos Inquiry',
                'label' => 'Manage inquiries',
            ],
            'cabnet.mykonosinquiry.manage_loyalty_continuity' => [
                'tab'   => 'Mykonos Inquiry',
                'label' => 'Manage loyalty continuity workspace',
            ],
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'mykonosinquiry' => [
                'label'       => 'Mykonos Inquiries',
                'url'         => Backend::url('cabnet/mykonosinquiry/inquiries'),
                'icon'        => 'icon-diamond',
                'permissions' => [
                    'cabnet.mykonosinquiry.manage_inquiries',
                    'cabnet.mykonosinquiry.manage_loyalty_continuity',
                ],
                'order'       => 500,
                'sideMenu'    => [
                    'inquiries' => [
                        'label'       => 'Inquiry Queue',
                        'icon'        => 'icon-inbox',
                        'url'         => Backend::url('cabnet/mykonosinquiry/inquiries'),
                        'permissions' => ['cabnet.mykonosinquiry.manage_inquiries'],
                    ],
                    'loyaltyrecords' => [
                        'label'       => 'Loyalty Continuity',
                        'icon'        => 'icon-repeat',
                        'url'         => Backend::url('cabnet/mykonosinquiry/loyaltyrecords'),
                        'permissions' => ['cabnet.mykonosinquiry.manage_loyalty_continuity'],
                    ],
                    'helpcenter' => [
                        'label'       => 'Workspace Docs',
                        'icon'        => 'icon-book',
                        'url'         => Backend::url('cabnet/mykonosinquiry/helpcenter'),
                        'permissions' => [
                            'cabnet.mykonosinquiry.manage_inquiries',
                            'cabnet.mykonosinquiry.manage_loyalty_continuity',
                        ],
                        'order'       => 30,
                    ],
                ],
            ],
        ];
    }
}
