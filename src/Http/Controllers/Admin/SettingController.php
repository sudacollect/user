<?php
/**
 * SettingController class
 */

namespace Gtd\Extension\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Gtd\Extension\User\Http\Controllers\AdminController;

use Gtd\Suda\Models\Setting;

use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Models\Certificate;

class SettingController extends AdminController
{
    
    
    public function setting(){
        
        $this->title('设置');
        
        $this->setMenu('ecdo_menu','ecdo_setting');
        $this->gate('ecdo_menu.ecdo_setting');
        return $this->display('setting');
    }


    //小程序设置
    public function miniapp(){
        
        $this->title('小程序配置');

        $data = Setting::where(['key'=>'ecdo_miniapp_setting','group'=>'Extension'])->first();
        $this->setData('data_list',unserialize($data['values']));
        
        
        $this->setMenu('setting_menu','miniapp');
        return $this->display('miniapp');
    }



    public function saveMiniapp(Request $request){
        
        $roles=[];
        
        $roles = [
            'name' => 'required',
            'appid' => 'required',
            'secret' => 'required',
            'mchid' => 'required',
            'key' => 'required',
        ];
        
        $messages = [
            'name.required'=>'请填写小程序名称',
            'secret.required'=>'请填写secret',
            'appid.required'=>'请填写appid',
            'mchid.required'=>'请填写商户号',
            'key.required'=>'请填写商户密匙',
        ];
        
        $response_msg = '';
        $ajax_result = $this->ajaxValidator($request->all(),$roles,$messages,$response_msg);
        
        if(!$response_msg){
            
            $save = array(
                'name' => $request->name,
                'secret' => $request->secret,
                'appid' => $request->appid,
                'mchid' => $request->mchid,
                'key' => $request->key,
            );
            
            if($get = Setting::where(['key'=>'ecdo_miniapp_setting','group'=>'Extension'])->first()) {
                
                $data = [
                    'type'=>'text',
                    'values'=>serialize($save),
                ];
                Setting::where(['key'=>'ecdo_miniapp_setting','group'=>'Extension'])->update($data);
                
            }else{
                
                $settingModel = new Setting;
                $data = [
                    'key'=>'ecdo_miniapp_setting',
                    'group'=>'Extension',
                    'type'=>'text',
                    'values'=>serialize($save),
                ];
                $settingModel->fill($data)->save();
                
            }
            
        }else{
            $url = admin_url('extension/user/miniapp');
            return $this->responseAjax('fail',$response_msg,$url);
        }
        
        return $this->responseAjax('success','保存成功');
        
    }
    
}

