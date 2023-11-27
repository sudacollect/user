<?php
namespace Gtd\Extension\User\Http\Controllers\Admin;

//把这里改为自己需要使用的控制器，才能获取到，并且可以设置到$this->user;
use Gtd\Extension\User\Http\Controllers\AdminController;

use Gtd\Suda\Traits\MediaBoxTrait;

class MediasController extends AdminController
{
    use MediaBoxTrait;

    function mediaSetting(){
      //参数说明
      //guard: guard key, config/auth.php
      //onlyUser: 默认false, 是否只显示当前用户
      //resize: 默认true,自动生成缩略图
      //ratio: 默认false,是否缩放图片
      $this->guard = 'operate';
    }

}