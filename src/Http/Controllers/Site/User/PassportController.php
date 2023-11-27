<?php

namespace Gtd\Extension\User\Http\Controllers\Site\User;

use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;

use Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Validation\ValidationException;
use Validator;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Notifications\AfterRegisterNotify;
use Gtd\Extension\User\Notifications\PasswordResetNotify;
use Gtd\Extension\User\Models\UserChange;
use Gtd\Extension\User\Models\Invite;

class PassportController extends SiteUserController{
    
    use AuthenticatesUsers;
    
    
    public function showLoginForm(SessionStore $sessionStore,Request $request)
    {
        $this->title('用户登录');
        if($request->has('redirectTo')){
            $sessionStore->put('url.intended',$request->redirectTo);
        }
        $this->setData('login_name',$this->username());
        return $this->display('passport.login');
    }
    
    
    public function showRegisterForm(SessionStore $sessionStore,Request $request)
    {
        // return redirect()->to($this->prefix.'/passport/login');
        $this->title('用户注册');
        
        if($request->has('redirectTo')){
            $sessionStore->put('url.intended',$request->redirectTo);
        }

        $this->setData('use_invite_code',true);
        
        if($request->has('invitecode')){
            $this->setData('invite_code',$request->invitecode);
        }

        $this->setData('login_name',$this->username());
        return $this->display('passport.register');
    }
    
    public function showRegisterFinish(Request $request)
    {
        
        $this->title('完成注册');
        
        if($request->session()->has('finished_email')){
            
            $email = $request->session()->get('finished_email');
            $this->setData('email',$email);
            
            return $this->display('passport.register_finished');
            
        }else{
            
            return redirect()->to($this->prefix.'/passport/login');
        }
        
    }
    
    public function showRegisterCheck(Request $request)
    {
        $this->title('确认注册');
        if($request->has('token') && !empty($request->token)){
            //验证token的合法性
            $register_user = User::where('reset_token',$request->token)->where(['status'=>0])->first();
            
            //显示确认界面
            if($register_user){
                
                $this->setData('register_user',$register_user);
                
                return $this->display('passport.register_check');
            }
            if($request->session()->has('register_checked') && !empty($request->session()->get('register_checked'))){
                $this->setData('register_checked',$request->session()->get('register_checked'));
                return $this->display('passport.register_check');
            }
        }
        return redirect()->to($this->prefix.'/passport/login');
    }
    
    
    public function showPasswordReset(Request $request)
    {
        
        $this->title('找回密码');
        
        if($request->session()->get('reset_send')){
            
            $this->setData('reset_send',$request->session()->get('reset_send'));
        }
        
        if($request->token){
            
            $reset_user = User::where('reset_token',$request->token)->first();
            
            if($reset_user){
                $reset = UserChange::where('user_id',$reset_user->id)->first();
                if($reset){
                    if(Carbon::now()->diffInSeconds($reset->created_at) <= 24*60*60){
                        
                        $this->setData('reset_send','reset_send');
                        $this->setData('reset_user',$reset_user);
                        $this->setData('reset_user_id',sha1($reset_user->id));
                        return $this->display('passport.password_reset');
                    }
                }
                
            }
            
            return redirect()->to($this->prefix.'/passport/login');
        }
        
        return $this->display('passport.password_reset');
    }
    
    
    
    //to login
    public function login(SessionStore $sessionStore,Request $request)
    {
        
        
        $url_intended = $sessionStore->pull('url.intended');
        
        if(!empty($url_intended) && $url_intended!=NULL){
            $this->redirectTo = $url_intended;
        }
        
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        
        $this->incrementLoginAttempts($request);
        
        return $this->sendFailedLoginResponse($request);
    }
    
    //to register
    public function register(SessionStore $sessionStore,Request $request)
    {
        $url_intended = $sessionStore->pull('url.intended');
        
        if(!empty($url_intended) && $url_intended!=NULL){
            $this->redirectTo = $url_intended;
        }

        if(!$request->has('invite_code') || !$request->invite_code){
            return $this->sendFailedResponse('invite_code','请填写邀请码');
        }

        $invite_code = false;

        if($request->invite_code)
        {
            $invite = Invite::where(['invite_code'=>$request->invite_code])->first();
            if($invite && !$invite->invite_user_id){
                $invite_code = $request->invite_code;
            }else{
                // return $this->sendFailedResponse('invite_code','邀请码不存在');
            }
        }
        
        // //判断填写
        // if(!$request->has('email') || !$request->has('password')){
        //     return $this->sendFailedResponse('email','请填写邮箱和密码');
        // }
        //
        // //判断邮箱格式
        // if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
        //     return $this->sendFailedResponse('email','请填写正确的邮箱');
        // }
        //
        // //判断用户是否存在
        // if(User::where('email',$request->email)->first()){
        //     return $this->sendFailedResponse('email','此邮箱账户已经存在,请重新填写');
        // }
        
        $roles = [
            'username'=>'required|min:6|max:64|unique:gtd_users',
            'email'=>'required|email|unique:gtd_users',
            'nickname'=>'required',
            'password'=>[
                'required',
                'regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d])(?=.*[!$#%]).*$/i'
            ]
        ];
        $messages = [
            'username.required' =>'请填写用户名',
            'username.unique'   =>'用户名已经存在',
            'username.min'      =>'用户名最小长度6',
            'nickname.required' =>'请填写昵称',
            'email.required'    =>'请填写邮箱',
            'email.email'       =>'请填写邮箱',
            'email.unique'      =>'邮箱已经被注册,请重新填写',
            'password.required' =>'请填写密码',
            'password.regex'    =>'密码不能小于6位,至少包含字母、数字、!$#%中的一个',
        ];
        
        $this->customValidator($request->all(),$roles,$messages)->validate();
        
        

        $reset_token = md5($request->email.Str::random(12));
        
        //注册新用户
        $userObj = new User;
        
        $salt = Str::random(6);
        $userObj->fill([
            'type_id' => $this->usertype->id,
            'username' => $request->username,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'salt'  => $salt,
            'gender'  => 'secret',
            'password' => bcrypt($request->password.'#x-client-x#'.$salt),
            'status'    => 0,
            'invite_code' => $invite_code?$invite_code:0,
            'reset_token' => $reset_token,
        ])->save();
        
        $register_id = $userObj->id;
        
        $register_user = User::where('id',$register_id)->with('userType')->first();
        
        if($register_user){

            //关联邀请码
            if($invite_code)
            {
                Invite::where(['invite_code'=>$invite_code])->update([
                    'invite_user_id'=>$register_user->id,
                ]);
            }
            
            // 发送注册邮件进行验证
            $register_user->notify(new AfterRegisterNotify($register_user));
            
            return redirect()->to($this->prefix.'/passport/register/finished')->with(['finished_email'=>$request->email]);
            
        }else{
            return $this->sendFailedResponse('email','用户注册失败,请稍后重试');
        }
    }
    
    //to register check token
    public function registerCheck(Request $request)
    {
        //完成确认
        
        
        $register_user = User::where('email',$request->email)->first();
        
        if(!$register_user){
            return $this->sendFailedResponse('register','验证邮箱不存在,请重新注册');
        }
        
        if($register_user->register_check!=0){
            
            return $this->sendFailedResponse('register','已经验证完成,请勿重复验证');
            
        }
        
        if($register_user->email!=$request->email || $register_user->token!=$request->token){
            return $this->sendFailedResponse('register','验证失效, 请重新注册');
        }
        
        $register_user->update([
            'register_check' => 1,
        ]);
        
        return redirect()->to($this->prefix.'/passport/register/check?token='.$register_user->token)->with(['register_checked'=>$register_user->id]);
    }
    
    
    public function passwordReset(Request $request)
    {
        
        if($request->has('email') && $request->has('password')){
            return $this->passwordResetFinish($request);
        }
        
        if(!$request->has('email') || empty($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return $this->sendFailedResponse('email','邮箱错误,请重新填写');
        }
        
        $reset_user = User::where('email',$request->email)->first();
        
        if(!$reset_user){
            return redirect()->to($this->prefix.'/passport/password/reset')->with(['reset_send'=>-1]);
            // return $this->sendFailedResponse('email','帐号不存在');
        }
        
        $reset = UserChange::where('user_id',$reset_user->id)->first();
        
        if($reset){
            
            if(Carbon::now()->diffInSeconds($reset->created_at) <= 5*60){
                return $this->sendFailedResponse('email','密码重置邮件已经发送,请5分钟后重试');
            }else{
                UserChange::where('user_id',$reset_user->id)->delete();
            }
        }
        
        $reset_token = Str::random(32);
        User::where('id',$reset_user->id)->update([
            
            'reset_token' => $reset_token,
            
        ]);
        
        $userChange = new UserChange;
        $userChange->fill([
            'user_id'   => $reset_user->id,
            'email'     => $reset_user->email,
            'token'     => $reset_token,
        ])->save();
        
        //发送邮件
        $reset_user = User::where('id',$reset_user->id)->with('userType')->first();
        
        $reset_user->notify(new PasswordResetNotify($reset_user));
        
        return redirect()->to($this->prefix.'/passport/password/reset')->with(['reset_send'=>$reset_user->id]);
    }
    
    protected function passwordResetFinish(Request $request){
        
        $roles = [
            'password'=>'required|confirmed|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d])(?=.*[!$#%]).*$/'
        ];
        $messages = [
            'password.required'=>'请填写密码',
            'password.confirmed'=>'请确认新密码一致',
            'password.regex'=>'密码不能小于6位,至少包含字母、数字、!$#%中的一个',
        ];
        
        $this->customValidator($request->all(),$roles,$messages)->validate();
        
        
        
        $reset_user = User::where('email',$request->email)->first();
        
        if($reset_user){
            $salt = Str::random(6);
            User::where('id',$reset_user->id)->update([
                'salt'          => $salt,
                'password'      => bcrypt($request->password.'#x-client-x#'.$salt),
                'reset_token'   => Str::random(32),
                
            ]);
            
            UserChange::where('user_id',$reset_user->id)->delete();
            
            return redirect()->to($this->prefix.'/passport/password/reset')->with(['reset_send'=>'reset_success']);
            
        }
        
    }
    
    
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
    
    protected function credentials(Request $request)
    {
        // filter_var($email, FILTER_VALIDATE_EMAIL)
        // is_numeric($request->get('email')) && 
        if($this->username()=='phone'){
            return ['phone'=>$request->get('phone'),'password'=>$request->get('password'),'status'=>1, 'type_id'=>$this->usertype->id];
        }
        if($this->username()=='useranme'){
            return ['username'=>$request->get('username'),'password'=>$request->get('password'),'status'=>1, 'type_id'=>$this->usertype->id];
        }
        
        return ['email'=>$request->get('email'),'password'=>$request->get('password'),'status'=>1, 'type_id'=>$this->usertype->id];
        
        //return $request->only($this->username(), 'password','status');
    }
    
    
    public function logout(Request $request)
    {
        $this->guard()->logout();

        // $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
    
    protected function guard() {
        return Auth::guard('client');
    }
    
    
    public function username()
    {
        return config('suda_user.username','email');
    }
    

    public function isMobile($string)
    {
        return !!preg_match('/^1[3|4|5|6|7|8|9]\d{9}$/', $string);
    }
    
    protected function customValidator(array $data,$roles,$messages)
    {
        return Validator::make($data, $roles, $messages);
    }
    
    
    
}