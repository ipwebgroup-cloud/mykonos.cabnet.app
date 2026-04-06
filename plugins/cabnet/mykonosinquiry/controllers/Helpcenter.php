<?php namespace Cabnet\MykonosInquiry\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Helpcenter extends Controller
{
    public $requiredPermissions = [
        'cabnet.mykonosinquiry.manage_inquiries',
        'cabnet.mykonosinquiry.manage_loyalty_continuity',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Cabnet.MykonosInquiry', 'mykonosinquiry', 'helpcenter');
        $this->pageTitle = 'Workspace docs, help & glossary';
    }

    public function index()
    {
    }
}
