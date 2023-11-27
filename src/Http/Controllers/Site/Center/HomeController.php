<?php

namespace Gtd\Extension\User\Http\Controllers\Site\Center;

use Illuminate\Http\Request;
use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;
use Gtd\Extension\User\Models\UserType;

class HomeController extends SiteUserController
{
    protected $usertype_name = 'user';

    public function __construct() {
        parent::__construct();
        $this->usertype = UserType::where(['type_name'=>$this->usertype_name])->first();
        $this->setData('usertype',$this->usertype);
    }
    
    public function index()
    {
        $this->setData('sidebar_active','dashboard');
        return $this->display('center.index');
    }
    

    public function errorPage(Request $request)
    {
        $this->title('错误');
        
        $code = '404';
        $msg = '';
        if($request->session()->has('errors')){

            $errors = $request->session()->get('errors');
            $code = $errors->first('errcode');
            $msg = $errors->first('errmsg');
        }

        if($request->get('code')){
            $code = $request->get('code');
            $msg = $request->get('msg');
        }

        $code = $code?$code:'404';
        $msg = $msg?$msg:'相关信息没找到';

        $this->setData('code',$code);
        $this->setData('msg',$msg);

        return $this->display('center.error');
    }
}

