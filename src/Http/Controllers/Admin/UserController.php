<?php

namespace Gtd\Extension\User\Http\Controllers\Admin;

use App;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Log;
use Validator;
use Illuminate\Support\Facades\Hash;

use Gtd\Extension\User\Http\Controllers\AdminController;

use Response;

use Gtd\Suda\Models\Media;

use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Models\UserType;
use Gtd\Extension\User\Models\UserGrade;
use Gtd\Extension\User\Models\Certificate;
use Gtd\Extension\User\Models\CertificateApply;

use Gtd\Extension\User\Services\CertificateService;

class UserController extends AdminController
{
    
    function __construct()
    {
        parent::__construct();
        $this->objectModel = new User;
        $this->setMenu('user','index');
    }
    public function index(Request $request,$view='list')
    {
        $this->gate('user.index');

        $this->title('客户管理');

        $page_no = 0;
        $page_size=20;
        if($request->get('page')){
            $page_no = $request->get('page');
        }
        
        $objectModel = $this->objectModel;
        
        $data = false;
        $this->_filter($request->all(),$page_size,$page_no,$data);
        
        $this->setData('data_list',$data);
        
        return $this->display('user.list');
        
    }
    
    public function showAddForm()
    {
        $types = UserType::all();
        $this->setData('types',$types);

        $this->title('增加客户');
        $this->setData('modal_title','增加客户');
        return $this->display('user.add');
    }
    
    public function showEditForm($id=0)
    {
        
        $id = intval($id);
        
        $user = User::where('id','=',$id)->first();
        
        if(!$user){
            return redirect(admin_url('error'))->withErrors(['errcode'=>404,'errmsg'=>'没有相关数据']);
        }
        
        $this->setData('data',$user);
        
        $grades = UserGrade::all();
        $this->setData('grades',$grades);

        $this->title('编辑');
        $this->setData('modal_title','编辑');
        return $this->display('user.edit');
    }
    
    public function showObject(Request $request,$id)
    {
        $id = intval($id);
        
        
        //客户信息
        $user = User::where('id','=',$id)->first();
        
        if(!$user){
            return redirect(admin_url('error'))->withErrors(['errcode'=>404,'errmsg'=>'没有相关数据']);
        }
        
        $this->setData('data',$user);
        
        
        $page_size = 5;
        $page_no = 0;
        
        //授权信息
        
        $certi_list = Certificate::where('user_id',$id)->orderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
        $this->setData('certi_list',$certi_list);
        
        
        $this->title('查看客户');
        return $this->display('user.view');
    }
    
    public function save(Request $request)
    {
        
        $id = $request->id;
        
        $roles=[];
        
        if($id){
            $roles = [
                'username' => 'required|min:6|max:64|unique:gtd_users,username,'.$id,
                'email' => 'required|unique:gtd_users,email,'.$id,
                // 'phone' => 'required|unique:gtd_users,phone,'.$id,
                'nickname' => 'required',
                // 'realname' => 'required',
            ];
        }else{
            $roles = [
                'type_id'   => 'required',
                'username' => 'required|min:6|max:64|unique:gtd_users',
                'email' => 'required|unique:gtd_users',
                // 'phone' => 'required|unique:gtd_users',
                'password' => 'required',
                'nickname' => 'required',
                // 'realname' => 'required',
            ];
        }
        
        $messages = [
            'type_id.required'=>'请选择类型',
            'username.required'=>'请填写用户名',
            'username.unique'=>'用户名不能重复',
            'email.required'=>'请填写邮箱',
            'email.unique'=>'邮箱不能重复',
            'phone.required'=>'请填写手机号',
            'phone.unique'=>'手机号不能重复',
            'password.required'=>'请填写密码',
            'nickname.required'=>'请填写昵称',
            'realname.required'=>'请填写真实姓名',
        ];
        
        $response_msg = '';
        $ajax_result = $this->ajaxValidator($request->all(),$roles,$messages,$response_msg);
        
        $salt = Str::random(6);
        $password = '';
        if($request->password)
        {
            $password = bcrypt($request->password.'#x-client-x#'.$salt);
        }
        
        
        
        $objectModel = $this->objectModel;
        
        if(!$response_msg){
            
            
            if($id){
                
                $user = User::where('id',$id)->first();
                
                $objectModel->where('id',$id)->update([
                    'username'          => $request->username,
                    'nickname'          => $request->nickname,
                    'realname'          => $request->realname,
                    'phone'          => $request->phone,
                    'email'          => $request->email,
                    'gender'          => $request->gender,
                    'link_wechat'          => $request->link_wechat,
                    'link_qq'          => $request->link_qq,
                    'link_github'          => $request->link_github,
                    'province'      => $request->province,
                    'city'          => $request->city,
                    'district'      => $request->district,
                    'address'       => $request->address,
                    'status'        => $request->status?1:0,

                    'badge_star'        => $request->badge_star?1:0,
                    // 'badge_certificate'        => $request->badge_certificate?1:0,
                ]);
                $object_id = $id;
            }else{
                //名称
                $objectModel->type_id  = $request->type_id;
                $objectModel->username  = $request->username;
                $objectModel->nickname = $request->nickname;
                $objectModel->realname = $request->realname;
                $objectModel->gender = $request->gender;
                $objectModel->email = $request->email;
                $objectModel->phone = $request->phone;
                $objectModel->password = $password;
                $objectModel->salt = $salt;

                $objectModel->link_wechat = $request->link_wechat;
                $objectModel->link_qq = $request->link_qq;
                $objectModel->link_github = $request->link_github;
                
                $objectModel->province = $request->province;
                $objectModel->city = $request->city;
                $objectModel->district = $request->district;
                $objectModel->address = $request->address;

                $objectModel->status = $request->status?1:0;
                
                $objectModel->save();
                $object_id = $objectModel->id;
            }
        }
        
        
        
        if(isset($object_id) && $object_id){
            return $this->responseAjax('success','保存成功','self.refresh');
        }
        
        
        return $this->responseAjax('fail',$response_msg,'self.refresh');
        
    }
    
    public function deleteObject(Request $request)
    {
        
        if($request->id && !empty($request->id)){
            
            $data = User::where('id',$request->id)->first();
            
            if($data){
                User::where('id',$request->id)->delete();
                $url = '';
                return $this->responseAjax('success','删除成功',$url);
                
            }else{
                return $this->responseAjax('error','数据不存在,请重试');
            }
            
            
        }else{
            return $this->responseAjax('error','数据不存在,请重试');
        }
        
    }
    
    
    public function _filter($filter=[],$page_size=20,$page_no=0,&$data)
    {
        
        $objectModel = $this->objectModel;
        
        if($filter && array_key_exists('filter',$filter) && $filter['filter']=='true'){
            
            $comma = '';
            
            if(array_key_exists('page',$filter)){
                unset($filter['page']);
            }
            if(array_key_exists('filter',$filter)){
                unset($filter['filter']);
            }
            
            $sModel = $objectModel->where([]);
            
            foreach($filter as $k=>$v){
            
                //多选筛选
                if(is_string($v) && strpos($v,',')!=false){
                    $v = explode(',',$v);
                }
            
                if($k=='name'){
                    $sModel = $sModel->where('name','like',DB::raw("'%$v%'"));
                    $filter_arr[$k] = $v;
                    
                }else{
                    if(is_string($v)){
                        $sModel = $sModel->where([$k=>$v]);
                        $filter_arr[$k] = $v;
                    }
            
                    if(is_array($v)){
                        $sModel = $sModel->whereIn($k,$v);
                        $filter_arr[$k] = implode(',',$v);
                    }
                }
            }
            
            $data = $sModel->with('avatar')->with('userType')->with('userGrade')->OrderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
            
            $filter_arr['filter'] = 'true';
            $this->setData('filter_arr',$filter_arr);
            $comma = '';
            $filter_str='';
            foreach($filter_arr as $k=>$v){
                $filter_str .= $comma.$k.'='.$v;
                $comma = '&';
            }
            if($filter_str){
                $filter_str .= '&filter=true';
                $this->setData('filter_str',$filter_str);
            }
            
        }else{
            $this->setData('filter_arr',[]);
            $objectModel = $objectModel->where([])->with('avatar')->with('userType')->with('userGrade');
            $data = $objectModel->OrderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
        }
        
    }
    

    public function showPassForm(Request $request,$id=0)
    {
        
        $id = intval($id);
        
        $user = User::where('id','=',$id)->first();
        
        if(!$user){
            return $this->responseAjax('fail','用户不存在');
            // return redirect(admin_url('error'))->withErrors(['errcode'=>404,'errmsg'=>'没有相关数据']);
        }
        
        $this->setData('data',$user);
        
        
        $this->title('编辑');
        $this->setData('modal_title','编辑');
        return $this->display('user.password');
    }

    public function savePassword(Request $request)
    {
        
        $id = $request->id;
        
        $objectModel = $this->objectModel;
        
        if($id){

            $user = User::where('id',$id)->first();

            

            if($request->new_password != $request->confirm_password)
            {
                return $this->responseAjax('fail','新密码输入不一致');
            }

            $salt = Str::random(6);
            $new_password = bcrypt($request->new_password.'#x-client-x#'.$salt);
            
            $objectModel->where('id',$id)->update([
                'password'   => $new_password,
                'salt'    => $salt,
            ]);

            return $this->responseAjax('success','保存成功', 'self.refresh');
        }
        
        
        
        return $this->responseAjax('fail','系统异常','self.refresh');
        
    }

    // 审核认证
    public function showCertificate(Request $request,$id=0)
    {
        
        $id = intval($id);
        
        $user = User::where('id','=',$id)->first();
        
        if(!$user){
            return $this->responseAjax('fail','用户不存在');
        }
        
        $this->setData('user',$user);

        // 当前认证
        $certificate = Certificate::where('user_id',$user->id)->first();

        // 申请认证
        $certificate_apply = CertificateApply::where('user_id',$user->id)->first();

        $this->setData('item',$certificate);
        if(!$certificate_apply)
        {
            $certificate_apply = $certificate;
        }
        $this->setData('item_apply',$certificate_apply);
        
        
        $this->title('审核认证');
        $this->setData('modal_title','审核认证');
        return $this->display('user.certificate');
    }

    public function saveCertificate(Request $request)
    {
        
        $user_id = $request->user_id;
        
        $objectModel = $this->objectModel;
        
        if($user_id){

            $item = Certificate::where(['user_id'=>$user_id])->first();

            $messages = [
                'certi_type.required'=>'请选择认证类型',
                'certi_name.required'=>'请填写认证名称',
                'certi_name.min'=>'认证名称长度不能小于2',
                'certi_name.unique'=>'认证名称已被注册',
                'certi_no.required'=>'请填写认证代码',
                'certi_no.min'=>'认证代码长度不能小于2',
                'certi_no.unique'=>'认证代码已被注册',
            ];
            
            $response_msg = '';
            $request_data = $request->all();
    
            if($item){
                
                $roles = [
                    'certi_type' => 'required',
                    'certi_name' => 'required|min:2|max:255|unique:gtd_certificates,certi_name,'.$item->id,
                    'certi_no' => 'required|min:2|max:255|unique:gtd_certificates,certi_no,'.$item->id,
                ];
    
                
                $ajax_result = $this->ajaxValidator($request_data,$roles,$messages,$response_msg);
    
            }else{
                $roles = [
                    'certi_type' => 'required',
                    'certi_name' => 'required|min:2|max:255|unique:gtd_certificates,certi_name',
                    'certi_no' => 'required|min:2|max:255|unique:gtd_certificates,certi_no',
                ];
                $ajax_result = $this->ajaxValidator($request_data,$roles,$messages,$response_msg);
            }

            
            // 更新认证信息
            

            if($item)
            {
                $item->update([
                    'certi_name' => $request->certi_name,
                    'certi_type' => $request->certi_type,
                    'certi_no' => $request->certi_no,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);
                
            }else{

                $certificateObj = new Certificate;

                $certificateObj->order_id   = 'S'.time();
                $certificateObj->user_id    = $user_id;
                $certificateObj->operate_id  = $this->user->id;
                $certificateObj->team_id    = 0;
                $certificateObj->certi_name = $request->certi_name;
                $certificateObj->certi_type = $request->certi_type;
                $certificateObj->certi_no   = $request->certi_no;
                $certificateObj->certi_product = 'Suda';
                
                $certificateObj->start_date = $request->start_date;
                $certificateObj->end_date   = $request->end_date;
                
                $certificateObj->save();
            }

            $certi = Certificate::where(['user_id'=>$user_id])->first();

            $post_data = [
                'product' => $certi->certi_product,
                'certi_no' => $certi->certi_no,
                'start_date' => $certi->start_date,
                'end_date' => $certi->end_date,
                'timestamp' => Carbon::parse($certi->updated_at)->timestamp
            ];
            $serial = CertificateService::getSignature($post_data);
            $certi->update([
                'serial' => $serial,
            ]);

            if(Carbon::parse($request->start_date)->lte(now()) && Carbon::parse($request->end_date)->gt(now()))
            {
                User::where(['id'=>$user_id])->update([
                    'badge_certificate' => 1,
                ]);
            }else{
                User::where(['id'=>$user_id])->update([
                    'badge_certificate' => 0,
                ]);
            }


            // 清除认证申请
            CertificateApply::where(['user_id'=>$user_id])->delete();

            return $this->responseAjax('success','保存成功', 'self.refresh');
        }
        
        
        
        return $this->responseAjax('fail','系统异常','self.refresh');
        
    }
}
