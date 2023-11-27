<?php
/*
|--------------------------------------------------------------------------
| 菜单扩展
|--------------------------------------------------------------------------
|
| 目前支持扩展菜单项
| 1. 支持对当前已存在菜单的扩展
| 2. 支持扩展新的菜单项
|
*/

return [
    
    'user'=>[
        'title'     => '用户',
        'slug'      => 'user',
        'url'       => 'index',
        'icon_class'=> 'ion-apps',
        'icon_bg_color'=> '#000000',
        'font_color'=> '#ff0000',
        'group'     => 'user',
        'target'     => '_self',
        'order'     => 0,
        'children'  => [
            [
                'title'     => '用户',
                'slug'      => 'index',
                'url'       => 'index',
                'icon_class'=> 'ion-person',
                'target'     => '_self',
                'order'     => 0,
                'methods'   => [
                    'create' => '创建',
                    'update' => '编辑',
                    'read'   => '读取',
                    'delete' => '删除',
                ],
            ],
            [
                'title'     => '等级',
                'slug'      => 'grades',
                'url'       => 'grades',
                'icon_class'=> 'ion-apps',
                'target'     => '_self',
                'order'     => 1,
                'methods'   => [
                    'create' => '创建',
                    'update' => '编辑',
                    'read'   => '读取',
                    'delete' => '删除',
                ],
            ],
        ]
        
    ],
    
    'setting'=>[
        'title'     => '设置',
        'slug'      => 'setting',
        'url'       => 'setting',
        'icon_class'=> 'ion-help-buoy',
        'icon_bg_color'=> '#000000',
        'font_color'=> '#ff0000',
        'group'     => 'setting',
        'target'     => '_self',
        'order'     => 1,
        'children'  => [
            [
                'title'     => '类型',
                'slug'      => 'types',
                'url'       => 'types',
                'icon_class'=> 'ion-person',
                'target'     => '_self',
                'order'     => 0,
            ],
            [
                'title'     => '配置',
                'slug'      => 'setting',
                'url'       => 'setting',
                'icon_class'=> 'ion-gears',
                'target'     => '_self',
                'order'     => 1,
                'methods'   => [
                    'basic' => '基础配置',
                    'email' => '邮件',
                    'sms'   => '短信',
                    'invite'   => '邀请',
                    'service' => '服务',
                ],
            ],
        ]
    ],
    
];