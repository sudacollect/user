<?php

namespace Gtd\Extension\User\Http\Controllers;


use Response;
use Illuminate\Http\Request;
use Auth;
use View;
use Closure;
use Validator;
use Illuminate\Support\Facades\Cache;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;

use Gtd\Suda\Http\Controllers\SiteController as SiteCtl;

use Gtd\Extension\User\Models\UserType;
use Gtd\Extension\User\Models\User;


class SiteController extends SiteCtl{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // public $extension_view = 'user';

    protected $except_uris = [];

    public $usertype = null;
    public $prefix;
    
    
    
    public function showNewVersion()
    {

        //获取最新的产品版本
        
        return Response::json(['product'=>'suda','version'=>'2.0'], 200);
        
    }
    
    public function display($view)
    {
        if(isset($this->user)){
            $this->setData('user',$this->user);
        }
        $this->setData('usertype',$this->usertype);
        $this->setData('prefix',$this->prefix);
        // return parent::display($view);
        $ext = app('suda_extension')->use('user')->extension;
        if(!$ext)
        {
            exit('404');
        }
        
        View::addNamespace('extension', $ext['path'].'/resources/views/site');
        return parent::display('view_extension_user::site.'.$view);
    }
    
    public function validator($data,$roles,$messages)
    {
        if($data && $roles && $messages && is_array($roles)){
            return Validator::make($data, $roles,$messages);
        }
    }
    
    
    
    public function ajaxValidator($data,$roles,$messages=array(),&$response_msg=''){
        
        $default_messages = [];
        
        $messages = array_merge($default_messages,$messages);
        
        $validator = $this->validator($data,$roles,$messages);
        
        if (!$validator->passes()) {
            $msgs = $validator->messages();
            foreach ($msgs->all() as $msg) {
                $response_msg .= $msg . '</br>';
            }
            $response_type = false;
        }else{
            $response_type = true;
        }
        return $response_type;
    }
    
    // ajax表单提交返回方法
    public function responseAjax($type='fail',$msg='',$url='',$data=[]){
        // ajax返回请求
        $type=='failed'?$type='fail':'';
        
        if($url){
            if(substr($url,0,4)!='http'){
                $url = in_array($url,['ajax.close','self.refresh'])?$url:admin_url($url);
            }
        }else{
            $url = '';
        }
        $arr = array(
            'response_type' => $type,
            'response_msg' => $msg,
            'response_url' => $url
        );
        
        if($data){
            $arr = array_merge($arr,$data);
        }
        
        $code=422;
        if($type=='success' || $type=='info' || $type=='warning' || $type=='danger'){
            $code=200;
        }
        
        return Response::json($arr, $code);
    }
    
    public function sendFailedResponse($key,$values)
    {
        throw ValidationException::withMessages([
            $key => [$values],
        ]);
    }

    protected function isExceptConfig($request){

        foreach ($this->except_uris as $except) {
                
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            
            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;

    }


    public function dispatchError($code,$msg='')
    {
        $req = \Request::create('center/error', 'GET',['code'=>$code,'msg'=>$msg]);
        //return \Route::dispatch($req);
        \Request::replace($req->input());
        return \Route::dispatch($req)->getContent();
    }
    
}

