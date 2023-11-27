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
use Illuminate\Validation\Rule;

use Gtd\Extension\User\Http\Controllers\AdminController;

use Response;

use Gtd\Suda\Models\Media;

use Redirect;
use Illuminate\Support\Facades\DB;

use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Models\UserType;
use Gtd\Extension\User\Models\UserGrade;

class GradeController extends AdminController
{
    
    function __construct()
    {
        parent::__construct();
        $this->objectModel = new UserGrade;
        $this->setMenu('user','grades');
    }
    public function index(Request $request,$active_view='list')
    {
        $types = UserType::all();
        $this->setData('types',$types);

        $this->gate('user.grades');

        $this->title('等级管理');

        $page_no = 0;
        $page_size=20;
        if($request->get('page')){
            $page_no = $request->get('page');
        }
        
        $data = false;
        $filter = $request->all();
        if($active_view && $active_view!='list')
        {
            $filter['filter'] = 'true';
            $filter['type_name'] = $active_view;
        }
        $this->_filter($filter,$page_size,$page_no,$data);
        
        $this->setData('data_list',$data);
        $this->setData('active',$active_view);
        
        return $this->display('grade.list');
        
    }
    
    public function showAddForm()
    {
        $types = UserType::all();
        $this->setData('types',$types);
        
        $this->title('增加');
        $this->setData('modal_title','增加');
        return $this->display('grade.add');
    }
    
    public function showEditForm($id=0)
    {
        $types = UserType::all();
        $this->setData('types',$types);

        $id = intval($id);
        
        $user = UserGrade::where('id','=',$id)->first();
        
        if(!$user){
            return redirect(admin_url('error'))->withErrors(['errcode'=>404,'errmsg'=>'没有相关数据']);
        }
        
        $this->setData('data',$user);
        
        
        $this->title('编辑');
        $this->setData('modal_title','编辑');
        return $this->display('grade.edit');
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
                'grade_name' => 'required|min:2|max:64|'.
                Rule::unique('gtd_user_grades')->where('type_id',$request->type_id)->ignore($request->id,'id')
            ];
        }else{
            $roles = [
                'type_id'   => 'required',
                'grade_name' => 'required|min:2|max:64|'.Rule::unique('gtd_user_grades')->where('type_id',$request->type_id),
            ];
        }
        
        $messages = [
            'type_id.required'=>'请选择类型',
            'grade_name.required'=>'请填写等级',
            'grade_name.unique'=>'等级不能重复',
        ];
        
        $response_msg = '';
        $ajax_result = $this->ajaxValidator($request->all(),$roles,$messages,$response_msg);
        
        
        $objectModel = $this->objectModel;
        
        if(!$response_msg){
            
            
            if($id){
                
                $user = UserGrade::where('id',$id)->first();
                
                $objectModel->where('id',$id)->update([
                    'grade_name' => $request->grade_name,
                    'status'    => $request->status?1:0
                ]);
                $object_id = $id;
            }else{
                //名称
                $objectModel->type_id  = $request->type_id;
                $objectModel->grade_name  = $request->grade_name;
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
            
            $data = UserGrade::where('id',$request->id)->first();
            
            if($data){
                $user_count = User::where(['grade_id'=>$data->id])->count();
                if($user_count>0)
                {
                    return $this->responseAjax('error','存在关联用户，无法删除');
                }
                UserGrade::where('id',$request->id)->delete();
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
            
                if($k=='grade_name'){
                    $sModel = $sModel->where('grade_name','like',DB::raw("'%$v%'"));
                    $filter_arr[$k] = $v;
                    
                }elseif($k=='type_name'){
                    $sModel = $sModel->whereHas('userType',function($query) use ($v) {
                        $query->where('type_name','like',DB::raw("'%$v%'"));
                    });
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
            
            $data = $sModel->with('userType')->OrderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
            
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
            $objectModel = $objectModel->where([])->with('userType');
            $data = $objectModel->OrderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
        }
        
    }
    
}
