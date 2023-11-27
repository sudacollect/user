<?php
namespace Gtd\Extension\User\Http\Controllers\Site\User;

use Illuminate\Http\Request;
use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;

use Gtd\Extension\User\Models\Certificate;

class CenterController extends SiteUserController{
    
    
    public function index()
    {
        
        $this->title('用户中心');
        
        $extension_count = 0;
        $buggle_new = 0;
        $buggle_count = 0;
        $buggle_fixed = 0;
        
        $count = compact('extension_count','buggle_count','buggle_new','buggle_fixed');
        
        $this->setData('count',$count);
        
        
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

