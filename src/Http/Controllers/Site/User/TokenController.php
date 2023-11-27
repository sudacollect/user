<?php
/**
 * config.php
 * 扩展应用 example
 * date 2018-04-16 00:08:34
 * @copyright ECDO. All Rights Reserved.
 */
 
namespace Gtd\Extension\User\Http\Controllers\Site\User;

use Illuminate\Http\Request;
use Gtd\Extension\User\Http\Controllers\Site\SiteUserController;
use Illuminate\Support\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

use Gtd\Extension\User\Models\Certificate;
use Gtd\Extension\User\Models\Product;

use Gtd\Extension\User\Services\CertificateService;

class TokenController extends SiteUserController
{   
    public function __construct(){
        
        $this->objectModel = new Certificate;
        
        $this->setData('sidebar_active','token');
        
        parent::__construct();
    }
    
    public function index(Request $request,$tab_active='all')
    {

        
        
        $this->title('token');
        
        $page_no = 0;
        $page_size=20;
        if($request->get('page')){
            $page_no = $request->get('page');
        }
        
        $data = false;
        $request_data = $request->all();
        if($tab_active=='disabled'){
            $request_data['filter'] = 'true';
            $request_data['enable'] = '0';
        }
        if($tab_active=='expiring'){
            $request_data['filter'] = 'true';
            $request_data['end_date_than'] = Carbon::now()->format('Y-m-d H:i:s');
            $request_data['end_date_less'] = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
        }
        if($tab_active=='expired'){
            $request_data['filter'] = 'true';
            $request_data['end_date_less'] = Carbon::now()->format('Y-m-d H:i:s');
        }

        // TODO 一个用户存在多个认证
        $this->_filter($request_data,$page_size,$page_no,$data);
        $this->setData('data_list',$data);


        $this->setData('tab_active',$tab_active);
        
        return $this->display('center.token.index');
    }

    public function reset(Request $request,$id){
        
        $this->title('域名授权');
        $this->setData('modal_title','域名授权');
        
        
        $certi = Certificate::where('id',$id)->where('user_id',$this->user->id)->first();
        
        if($certi){
            if(Carbon::parse($certi->end_date)->lte(now())){
                return $this->responseAjax('fail','已过期授权不可编辑');
            }

            $post_data = [
                'product' => $certi->certi_product,
                'certi_no' => $certi->certi_no,
                'start_date' => $certi->start_date,
                'end_date' => $certi->end_date,
                'timestamp' => Carbon::parse($certi->updated_at)->timestamp
            ];
            
            $serial = CertificateService::getSignature($post_data);

            Certificate::where('id',$id)->where('user_id',$this->user->id)->update([
                'serial' => $serial,
            ]);

            return $this->responseAjax('success','重置成功','self.refresh');
        }
        return $this->responseAjax('fail','数据不存在');
    }
    
    
    public function showToken(Request $request,$id){
        
        $this->title('token');
        $this->setData('modal_title','token');
        
        
        $certi = Certificate::where('id',$id)->where('user_id',$this->user->id)->first();
        
        if($certi){
            $this->setData('serial',$certi->serial);
        }else{
            return $this->responseAjax('fail','授权数据不存在');
        }
        
        return $this->display('center.token.view');
    }

    public function _filter($filter=[],$page_size=20,$page_no=0,&$data){
        
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
            
            $data = $sModel->where('user_id',$this->user->id)->OrderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
            
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
            $data = $objectModel->OrderBy('id','desc')->paginate($page_size,['*'],'page',$page_no);
            
        }
        
    }
    
}

