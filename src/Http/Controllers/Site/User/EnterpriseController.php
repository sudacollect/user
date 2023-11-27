<?php
 
namespace Gtd\Extension\User\Http\Controllers\Site\User;

use Illuminate\Http\Request;
use Gtd\Suda\Http\Controllers\Media\ImageController;
use Gtd\Suda\Models\Media;
use Illuminate\Support\Str;

use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;
use Gtd\Extension\User\Models\User;

class EnterpriseController extends SiteUserController
{
    
    
    public function index(){
        
        $this->title('企业资料');

        
        $this->setData('sidebar_active','enterprise');
        
        return $this->display('center.enterprise.index');
    }
    
    public function save(Request $request){
        
        $roles = [
            'company'=>'required|min:4|max:255',
        ];
        
        $messages = [
            'company.required'=>'请填写名称',
            'company.min'=>'名称长度不能小于4',
        ];
        
        $this->validator($request->all(),$roles,$messages)->validate();
        
        
        $this->user->update([
            
            'company'=>$request->company,
            'company_license'=>$request->company_license,
            'certified'=>1,
        ]);
        
        return redirect()->to('center/enterprise')->with('success','认证已提交');
    }
    
}

