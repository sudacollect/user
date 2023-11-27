<?php

$controller_prefix = "\\Gtd\\Extension\\User\\Http\\Controllers\\Admin\\";

Route::group([
    'as'         => 'user.',
    'prefix'     => 'user',
], function ($router) use ($controller_prefix) {

    
    // 图片选择窗口
    Route::get('medias/load-modal/{media_type}', 'MediasController@loadModal');
    Route::get('medias/modal/{media_type}', 'MediasController@modal');
    // 上传
    Route::post('medias/upload/image/{media_type?}', 'MediasController@uploadMedia');
    // 删除
    Route::post('medias/remove/image/{media_type?}', 'MediasController@removeMedia');

    Route::get('index', $controller_prefix.'UserController@index');
    
    //用户管理
    Route::get('users', $controller_prefix.'UserController@index');
    Route::get('user/add', $controller_prefix.'UserController@showAddForm');
    Route::post('user/save', $controller_prefix.'UserController@save');
    Route::get('user/edit/{id}', $controller_prefix.'UserController@showEditForm');
    Route::post('user/delete/{id}', $controller_prefix.'UserController@deleteObject');
    Route::get('user/{id}', $controller_prefix.'UserController@showObject');

    Route::get('user/password/{id}', $controller_prefix.'UserController@showPassForm');
    Route::post('user/password/save', $controller_prefix.'UserController@savePassword');
    
    Route::get('user/certificate/{id}', $controller_prefix.'UserController@showCertificate');
    Route::post('user/certificate/save', $controller_prefix.'UserController@saveCertificate');

    //类型管理
    Route::get('types', $controller_prefix.'TypeController@index');
    Route::get('type/add', $controller_prefix.'TypeController@showAddForm');
    Route::post('type/save', $controller_prefix.'TypeController@save');
    Route::get('type/edit/{id}', $controller_prefix.'TypeController@showEditForm');
    Route::post('type/delete/{id}', $controller_prefix.'TypeController@deleteObject');
    Route::get('type/{id}', $controller_prefix.'TypeController@showObject');
    
    //等级管理
    Route::get('grades/{type?}', $controller_prefix.'GradeController@index');
    Route::get('grade/add', $controller_prefix.'GradeController@showAddForm');
    Route::post('grade/save', $controller_prefix.'GradeController@save');
    Route::get('grade/edit/{id}', $controller_prefix.'GradeController@showEditForm');
    Route::post('grade/delete/{id}', $controller_prefix.'GradeController@deleteObject');
    Route::get('grade/{id}', $controller_prefix.'GradeController@showObject');

    Route::get('setting', $controller_prefix.'HomeController@setting');
    
    Route::get('miniapp', $controller_prefix.'HomeController@miniapp');
    Route::post('miniapp/save', $controller_prefix.'HomeController@saveMiniapp');
    
});
