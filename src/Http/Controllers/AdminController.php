<?php

namespace Gtd\Extension\User\Http\Controllers;

use Gtd\Suda\Http\Controllers\Admin\ExtensionController;

class AdminController extends ExtensionController{
    
    public $single_extension_menu = true;

    public function display($view)
    {
        return parent::display('view_extension_user::admin.'.$view);
    }
}

