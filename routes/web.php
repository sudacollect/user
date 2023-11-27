<?php
/**
 * config.php
 * 扩展应用 example
 * date 2018-04-16 00:08:34
 * @copyright ECDO. All Rights Reserved.
 */
 

$controller_prefix = "\\Gtd\\Extension\\User\\Http\\Controllers\\Site\\";


//个人页
Route::get('p/{link?}', $controller_prefix.'Open\UserController@profile');

Route::group([
    'as'        => 'passport-user-type.',
    'prefix'    => 'x-{usertype}',
    'where'     =>['usertype'=>'[a-zA-Z]+']
], function ($router) use ($controller_prefix) {
    Route::group([
        'as'         => 'passport.',
        'prefix'     => 'passport',
    ], function ($router) use ($controller_prefix) {
        
        //登录
        Route::get('login', $controller_prefix.'User\PassportController@showLoginForm');
        Route::post('login', $controller_prefix.'User\PassportController@login');
    
        //注册
        Route::get('register', $controller_prefix.'User\PassportController@showRegisterForm');
        Route::post('register', $controller_prefix.'User\PassportController@register');
    
        //注册完成
        Route::get('register/finished', $controller_prefix.'User\PassportController@showRegisterFinish');
    
    
        //验证注册
        Route::get('register/check', $controller_prefix.'User\PassportController@showRegisterCheck');
        Route::post('register/check', $controller_prefix.'User\PassportController@registerCheck');
    
        //密码修改
        Route::get('password/reset', $controller_prefix.'User\PassportController@showPasswordReset');
        Route::post('password/reset', $controller_prefix.'User\PassportController@passwordReset');
    
        //退出
        Route::post('logout', $controller_prefix.'User\PassportController@logout');
    });
});



//center中心

Route::group([
    'as'         => 'center.',
    'prefix'     => 'center',
], function ($router) use ($controller_prefix) {
    
    Route::get('/', $controller_prefix.'Center\HomeController@index');

    //====== 个人资料 ================================================
    Route::get('profile', $controller_prefix.'User\ProfileController@index');
    Route::post('profile/update', $controller_prefix.'User\ProfileController@save');

    //修改邮箱
    Route::get('profile/email', $controller_prefix.'User\ProfileController@showEmail');
    Route::post('profile/email', $controller_prefix.'User\ProfileController@saveEmail');
    Route::post('profile/email/sendcode', $controller_prefix.'User\ProfileController@SendEmailCode');

    //修改密码
    Route::get('profile/password', $controller_prefix.'User\ProfileController@showPassword');
    Route::post('profile/password', $controller_prefix.'User\ProfileController@savePassword');

    // 企业资料
    Route::get('enterprise', $controller_prefix.'User\EnterpriseController@index');
    Route::post('enterprise/update', $controller_prefix.'User\EnterpriseController@save');


    // 认证
    Route::get('certificate', $controller_prefix.'User\CertificateController@index');
    Route::get('certificate/apply', $controller_prefix.'User\CertificateController@showApply');
    Route::post('certificate/apply', $controller_prefix.'User\CertificateController@saveApply');


    //====== 邀请 ================================================
    Route::get('invite', $controller_prefix.'User\InviteController@index');
    Route::post('invite/add', $controller_prefix.'User\InviteController@add');
    Route::post('invite/reset/{code}', $controller_prefix.'User\InviteController@reset');

    //====== token ================================================
    Route::get('tokens', $controller_prefix.'User\TokenController@index');
    Route::get('token/list/{expiring?}', $controller_prefix.'User\TokenController@index');
    Route::get('token/add', $controller_prefix.'User\TokenController@showAddForm');
    Route::get('token/edit/{id}', $controller_prefix.'User\TokenController@showEditForm');
    Route::post('token/save', $controller_prefix.'User\TokenController@save');
    Route::post('token/reset/{id}', $controller_prefix.'User\TokenController@reset');

    Route::get('token/show/{id}', $controller_prefix.'User\TokenController@showToken');

    // 团队管理
    Route::get('myteam', $controller_prefix.'Team\TeamController@myTeam');
    
    
});
