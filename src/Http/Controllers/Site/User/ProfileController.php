<?php
 
namespace Gtd\Extension\User\Http\Controllers\Site\User;

use Illuminate\Http\Request;
use Gtd\Suda\Http\Controllers\Media\ImageController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;
use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Notifications\ChangeEmailNotify;

use Gtd\Suda\Models\Media;
use Gtd\Suda\Traits\AvatarTrait;

class ProfileController extends SiteUserController
{
    use AvatarTrait;
    
    public function index(){
        
        $this->title('会员资料');
        
        $this->setData('sidebar_active','profile');
        
        return $this->display('center.profile.index');
    }
    
    public function save(Request $request){
        
        $roles = [
            // 'name'=>'required|min:6|max:64|unique:gtd_users,name,'.$this->user->id,
            // 'email'=>'required|email|unique:gtd_users,email,'.$this->user->id,
            'nickname' => 'required|min:4|max:64|unique:gtd_users,nickname,'.$this->user->id,
            // 'phone'=>'required|numeric|regex:/^1[345678][0-9]{9}$/|unique:gtd_users,phone,'.$this->user->id,
        ];
        
        $messages = [
            'nickname.required'=>'请填写昵称',
            'nickname.unique'=>'昵称已经存在',
            'nickname.min'=>'用户名最小长度6',
            // 'email.required'=>'请填写邮箱',
            // 'email.email'=>'请填写邮箱',
            // 'email.unique'=>'此帐户已经存在,请重新填写',
            // 'phone.required'=>'请填写手机号',
            // 'phone.unique'=>'手机号已被占用',
            // 'phone.regex'=>'请填写正确手机号',
        ];
        
        $this->validator($request->all(),$roles,$messages)->validate();
        
        
        $this->user->update([
            'nickname'=>$request->nickname,
            'gender'=>$request->gender,
            'link_wechat'=>$request->link_wechat,
            'link_qq'=>$request->link_qq,
            'link_github'=>$request->link_github,
            'link_twitter'=>$request->link_twitter,
        ]);
        
        
        $this->uploadCroppie('user',$request->avatar,$this->user);
        return redirect()->to('center/profile')->with('success','更新完毕');
    }
    
    
    public function showEmail(){
        
        $this->title('更改资料');
        $this->setData('modal_title','更改邮箱');

        $this->setData('modal_size','small');
        
        return $this->display('center.profile.email');
    }
    
    public function SendEmailCode(Request $request){
        
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            
            if($request->email == $this->user->email){
                
                return $this->responseAjax('error','请重新填写新的邮箱');
                
            }
            
            if(session()->get('email_verify_code_time') > time()-30*60){
                
                return $this->responseAjax('error','验证码有效期30分钟,请稍后再试');
                
            }
            
            //发送邮件
            session()->put('email_verify_code_time',time());
            session()->put('email_verify_code',Str::random(6));
            $this->user->notify(new ChangeEmailNotify($request->email,session()->get('email_verify_code')));
            
            return $this->responseAjax('success','验证码已经发送');
            
        }
        
        
        
        return $this->responseAjax('error','邮箱填写错误');
    }
    
    public function saveEmail(Request $request){
        
        
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL) && $request->email != $this->user->email){
            
            if($request->verify_code == session()->get('email_verify_code')){
                //允许更换邮箱
                
                $this->user->update([
                    'email' => $request->email,
                ]);
                
                return $this->responseAjax('success','邮箱已更新','self.refresh');
            }
            
        }
        
        return $this->responseAjax('error','邮箱验证码有误,请重新提交');
    }
    
    
    public function showPassword()
    {
        $this->title('修改密码');

        $this->setData('sidebar_active','password');
        
        return $this->display('center.profile.password');
    }
    
    public function savePassword(Request $request){
        
        $roles = [
            'password'      => 'required',
            'new_password'  => 'required|confirmed|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d])(?=.*[!$#%]).*$/'
        ];
        $messages = [
            'password.required'         => '请填写当前密码',
            'new_password.required'     => '请填写新密码',
            'new_password.confirmed'    => '请确认新密码一致',
            'new_password.regex'        => '密码不能小于6位,至少包含字母、数字、!$#%中的一个',
        ];
        
        $this->validator($request->all(),$roles,$messages)->validate();
        
        $salt = Str::random(6);
        $new_password = bcrypt($request->new_password.'#x-client-x#'.$salt);

        $this->user->update([
            'salt'=>$salt,
            'password' => $new_password,
            'reset_token'=>Str::random(32),
        ]);
        
        return redirect()->to('center/profile/password')->with('success','密码已更新');
        
        // return $this->sendFailedResponse('password','密码更新失败,请重试');
    }
    
    
}

