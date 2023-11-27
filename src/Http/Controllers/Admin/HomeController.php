<?php
/**
 * HomeController class
 */

namespace Gtd\Extension\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Gtd\Extension\User\Http\Controllers\AdminController;

use Gtd\Suda\Models\Setting;

use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Models\Certificate;

class HomeController extends AdminController{
    
    
    public function index()
    {
        $this->setMenu('ecdo_menu','ecdo_index');
        $this->gate('ecdo_menu.ecdo_index');
        
        $this->title('管理');

        // DB::table('mediatables')->where(['mediatable_type'=>'Gtd\Suda\Models\Operate'])->update([
        //     'mediatable_type'=>'Gtd\Suda\Models\Operate'
        // ]);

        // DB::table('mediatables')->where(['mediatable_type'=>'Gtd\Suda\Models\Article'])->update([
        //     'mediatable_type'=>'Gtd\Suda\Models\Article'
        // ]);

        // DB::table('mediatables')->where(['mediatable_type'=>'Gtd\Suda\Models\Page'])->update([
        //     'mediatable_type'=>'Gtd\Suda\Models\Page'
        // ]);

        // DB::table('mediatables')->where(['mediatable_type'=>'Gtd\Suda\Models\Setting'])->update([
        //     'mediatable_type'=>'Gtd\Suda\Models\Setting'
        // ]);

        // DB::table('mediatables')->where(['mediatable_type'=>'Gtd\Suda\Models\Setting'])->update([
        //     'mediatable_type'=>'Gtd\Suda\Models\Setting'
        // ]);


        //统计相关数字
        $counts = [];

        $counts['user'] = User::count();
        $counts['certi_user'] = User::where('badge_certificate','=',1)->count();

        $counts['certi'] = Certificate::where([])->count();
        $counts['certi_count'] = Certificate::where([])->sum('id');

        $this->setData('counts',$counts);
        return $this->display('index');
    }
    
    
}

