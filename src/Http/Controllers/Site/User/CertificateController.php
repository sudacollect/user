<?php
namespace Gtd\Extension\User\Http\Controllers\Site\User;

use Illuminate\Http\Request;
use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;
use Illuminate\Support\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

use Gtd\Extension\User\Models\Certificate;
use Gtd\Extension\User\Models\CertificateApply;
use Gtd\Extension\User\Models\Product;

class CertificateController extends SiteUserController
{
    
    public function __construct(){
        
        $this->objectModel = new CertificateApply;
        
        $this->setData('sidebar_active','certificate');
        
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        
        $this->title('认证');
        
        $certificate = Certificate::where('user_id',$this->user->id)->first();
        $this->setData('item',$certificate);
        
        // $this->_filter($request_data,$page_size,$page_no,$data);
        
        

        return $this->display('center.certificate.index');
    }
    
    // 申请或变更授权
    public function showApply(Request $request)
    {
        $this->title('认证');
        $this->setData('modal_title','认证');
        $apply = CertificateApply::where('user_id',$this->user->id)->first();
        $this->setData('item',$apply);
        $this->setData('apply',$apply);
        if(!$apply)
        {
            $certificate = Certificate::where('user_id',$this->user->id)->first();
            $this->setData('item',$certificate);
        }
        
        return $this->display('center.certificate.apply');
    }


    public function saveApply(Request $request)
    {
        $item =  CertificateApply::where('user_id',$this->user->id)->first();

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
        
        $objectModel = $this->objectModel;
        
        if(!$response_msg){

            $request_data = [];
            $request_data['order_id']    = 0;
            $request_data['user_id']    = $this->user->id;
            $request_data['certi_name'] = $request->certi_name;
            $request_data['certi_no']   = $request->certi_no;
            $request_data['certi_type'] = $request->certi_type;
            
            if($item){
                CertificateApply::where('user_id',$this->user->id)->update($request_data);
            }else{
                $objectModel->order_id = $request_data['order_id'];
                $objectModel->user_id = $request_data['user_id'];
                $objectModel->certi_name = $request_data['certi_name'];
                $objectModel->certi_no = $request_data['certi_no'];
                $objectModel->certi_type = $request_data['certi_type'];
                
                $objectModel->save();
            }
            return $this->responseAjax('success','提交成功','self.refresh');
        }
        return $this->responseAjax('fail','提交失败: '.$response_msg);
        
    }
    
    
    
    public function _filter($filter=[],$page_size=20,$page_no=0,&$data){
        
        $objectModel = new Certificate;
        
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
            
                if($k=='domain'){
                    $sModel = $sModel->where('domain','like',DB::raw("'%$v%'"));
                    $filter_arr[$k] = $v;
                    
                }elseif($k=='end_date_than'){
                    $sModel = $sModel->whereDate('end_date','>',$v);
                    $filter_arr[$k] = $v;
                    
                }elseif($k=='end_date_less'){
                    $sModel = $sModel->whereDate('end_date','<',$v);
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
            
            $data = $sModel->where('user_id',$this->user->id)->OrderBy('id','desc')->with('user')->paginate($page_size,['*'],'page',$page_no);
            
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
            $objectModel = $objectModel->where('user_id',$this->user->id);
            $data = $objectModel->OrderBy('id','desc')->with('user')->paginate($page_size,['*'],'page',$page_no);
            
        }
        
    }
    
}

