<?php
 
namespace Gtd\Extension\User\Http\Controllers\Site;

use Response;
use Illuminate\Http\Request;
use Auth;
use View;
use Closure;

use Gtd\Suda\Http\Controllers\Media\ImageController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Gtd\Extension\User\Http\Controllers\SiteController;
use Gtd\Extension\User\Models\User;
use Gtd\Extension\User\Notifications\ChangeEmailNotify;

use Gtd\Suda\Models\Media;
use Gtd\Suda\Traits\AvatarTrait;

class SiteUserController extends SiteController {
    
    public $prefix =  'x-user';

    public function __construct() {
        parent::__construct();
        $this->middleware(function (Request $request,Closure $next){
            
            $usertype_name = 'user';
            $prefix_passport = 'passport';
            
            $prefix = $request->route()->action['prefix'];
            if($prefix == 'x-{usertype}/passport')
            {
                $params = $request->route()->parameters;
                if(is_array($params) && isset($params['usertype']))
                {
                    $usertype_name = $params['usertype'];
                }

                $usertype = UserType::where(['type_name'=>$usertype_name])->where('status','=',1)->first();
                if(!$usertype)
                {
                    exit('404 - user type not found.');
                }

                $prefix = 'x-'.$usertype->type_name;
                $prefix_passport = 'x-'.$usertype->type_name.'/passport';
                
                $this->usertype = $usertype;
                $this->prefix = $prefix;
            }

            

            $ignored_uris = [
                $prefix_passport.'/login',
                $prefix_passport.'/register',
                $prefix_passport.'/register/*',
                $prefix_passport.'/password/*',
            ];

            $this->except_uris = $ignored_uris;

            $except_do = $this->isExceptConfig($request);

            if(Auth::guard('client')->check()) {
                
                $this->user = auth('client')->user();
                
                $user = User::where('id',$this->user->id)
                    ->with('avatar')
                    ->with('certificate')
                    ->first();

                $this->user = $user;
                
                
                // if(!in_array($request->route()->uri(),$ignored_uris)){
                //     return $next($request);
                // }

                if(!$except_do){
                    return $next($request);
                }
                
                //$action = $request->route()->getAction();
                
                return redirect()->to('center');
                
            }else{
                
                if(!$except_do){
                    return redirect(url($prefix.'/passport/login'));
                }else{
                    return $next($request);
                }
            }
            
        });
    }

    public function display($view)
    {
        if(isset($this->user)){
            $this->setData('user',$this->user);
        }
        
        $this->setData('usertype',$this->usertype);

        //三个位置菜单
        //顶部导航
        $this->getNaviMenus();
        //侧边栏
        $this->getSideMenus();
        //用户下拉

        return parent::display($view);   
    }
    
    
    protected function getNaviMenus()
    {
        $user_navi_items = [
            // [
            //     'name' => '更新日志',
            //     'icon' => 'ion-sync-circle',
            //     'link' => url('versions'),
            // ],
            // [
            //     'name' => '在线社区',
            //     'icon' => 'ion-help-buoy',
            //     'link' => url('community'),
            // ]
        ];

        $this->setData('user_navi_items',$user_navi_items);
    }

    protected function getSideMenus()
    {
        $user_side_items = [
            [
                'name' => '订单',
                'icon' => 'ion-bug-outline',
                'link' => url('center/orders'),
                'children' => [
                    [
                        'name' => '我的订单',
                        'icon' => 'ion-cube',
                        'link' => url('center/orders'),
                    ],
                ],
            ],
            [
                'name' => 'Buggle',
                'icon' => 'ion-bug-outline',
                'link' => url('versions'),
                'children' => [
                    [
                        'name' => '待处理',
                        'icon' => 'ion-bug-outline',
                        'link' => url('buggle/list'),
                    ],
                    [
                        'name' => '已回复',
                        'icon' => 'ion-bug-outline',
                        'link' => url('buggle/list'),
                    ],
                ],
            ],
        ];

        $this->setData('user_side_items',$user_side_items);
    }
}