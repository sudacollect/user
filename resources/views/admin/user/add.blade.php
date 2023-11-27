@extends('view_path::component.modal')
@section('content')
<div class="modal-body">
<form class="form handle-form" role="form" method="POST" action="{{ admin_url('extension/user/user/save') }}">
    @csrf
    
    <div class="row mb-3 row{{ $errors->has('type_id') ? ' has-error' : '' }}">
        
        <label for="type_id" class="col-sm-3 col-form-label">
            用户类型
        </label>
        <div class="col-sm-6">
            <select id="type_id" name="type_id" class="form-select" placeholder="选择类型">
                <option>请选择类型</option>
                @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                @endforeach
            </select>
        </div>
        
    </div>
                      
                      
    <div class="row mb-3 row{{ $errors->has('username') ? ' has-error' : '' }}">
        
    <label for="inputName" class="col-sm-3 col-form-label">
        用户名*
    </label>
    <div class="col-sm-6">
        <input type="text" name="username" class="form-control" id="inputName" placeholder="请填写用户名">
        @if ($errors->has('username'))
            <span class="help-block">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
    </div>
    
    </div>

    <div class="row mb-3 row{{ $errors->has('nickname') ? ' has-error' : '' }}">
        
    <label for="nickname" class="col-sm-3 col-form-label">
        昵称*
    </label>
    <div class="col-sm-6">
        <input type="text" name="nickname" class="form-control" id="nickname" placeholder="请填写昵称">
        @if ($errors->has('nickname'))
            <span class="help-block">
                <strong>{{ $errors->first('nickname') }}</strong>
            </span>
        @endif
    </div>
    
    </div>

    <div class="row mb-3 row{{ $errors->has('realname') ? ' has-error' : '' }}">
        
    <label for="realname" class="col-sm-3 col-form-label">
        真实姓名*
    </label>
    <div class="col-sm-6">
        <input type="text" name="realname" class="form-control" id="realname" placeholder="请填写真实姓名">
        @if ($errors->has('realname'))
            <span class="help-block">
                <strong>{{ $errors->first('realname') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    <div class="row mb-3 row{{ $errors->has('gender') ? ' has-error' : '' }}">
        
    <label for="gender" class="col-sm-3 col-form-label">
        性别
    </label>
    <div class="col-sm-6">
        <select id="gender" name="gender" class="form-select" placeholder="选择类型">
            <option value="male">男</option>
            <option value="female">女</option>
            <option value="secret">保密</option>
            <option value="unknow">其他</option>
            
        </select>
    </div>
    
    </div>
    
    <div class="row mb-3 row{{ $errors->has('phone') ? ' has-error' : '' }}">
        
    <label for="inputName" class="col-sm-3 col-form-label">
        手机号*
    </label>
    <div class="col-sm-6">
        <input type="text" name="phone" class="form-control" id="phone" placeholder="请填写手机号">
        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    <div class="row mb-3 row{{ $errors->has('email') ? ' has-error' : '' }}">
        
    <label for="inputName" class="col-sm-3 col-form-label">
        邮箱*
    </label>
    <div class="col-sm-6">
        <input type="text" name="email" class="form-control" id="email" placeholder="请填写邮箱">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    
    </div>

    <div class="row mb-3 row{{ $errors->has('password') ? ' has-error' : '' }}">
        
    <label for="password" class="col-sm-3 col-form-label">
        密码*
    </label>
    <div class="col-sm-6">
        <input type="text" name="password" class="form-control" id="password" placeholder="请填写密码">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    <div class="row mb-3 row{{ $errors->has('link_wechat') ? ' has-error' : '' }}">
        
    <label for="link_wechat" class="col-sm-3 col-form-label">
        微信
    </label>
    <div class="col-sm-6">
        <input type="text" name="link_wechat" class="form-control" id="link_wechat" placeholder="请填写微信">
        @if ($errors->has('link_wechat'))
            <span class="help-block">
                <strong>{{ $errors->first('weclink_wechathat') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    <div class="row mb-3 row{{ $errors->has('link_qq') ? ' has-error' : '' }}">
        
    <label for="link_qq" class="col-sm-3 col-form-label">
        QQ
    </label>
    <div class="col-sm-6">
        <input type="text" name="link_qq" class="form-control" id="link_qq" placeholder="请填写QQ">
        @if ($errors->has('link_qq'))
            <span class="help-block">
                <strong>{{ $errors->first('link_qq') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    
    <div class="row mb-3 row{{ $errors->has('link_github') ? ' has-error' : '' }}">
        
    <label for="link_github" class="col-sm-3 col-form-label">
        Github
    </label>
    <div class="col-sm-6">
        <input type="text" name="link_github" class="form-control" id="link_github" placeholder="请填写Github帐号">
        @if ($errors->has('link_github'))
            <span class="help-block">
                <strong>{{ $errors->first('link_github') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    <div class="row mb-3 row {{ $errors->has('district') ? ' has-error' : '' }}">
        
    <label for="district" class="col-sm-3 col-form-label">
        省市区
    </label>
    <div class="col-sm-9">
        <div data-toggle="distpicker" class="d-flex flex-row">
            <select name="province" data-province="选择省" class="form-select input-sm"></select>
            <select name="city" data-city="选择市" class="form-select input-sm"></select>
            <select name="district" data-district="选择区" class="form-select input-sm"></select>
            
        </div>
    </div>
    
    </div>
    
    
    <div class="row mb-3 row{{ $errors->has('address') ? ' has-error' : '' }}">
        
    <label for="address" class="col-sm-3 col-form-label">
        详细地址
    </label>
    <div class="col-sm-6">
        <input type="text" name="address" class="form-control" id="address" placeholder="详细地址">
        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
    
    </div>
    
    
    <div class="row mb-3 row">
    <div class="offset-sm-3 col-sm-6">
        <button type="submit" class="btn btn-primary">{{ trans('提交保存') }}</button>
    </div>
    </div>
    
</form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('.handle-form').ajaxform();
        
        
        $('div[data-toggle="distpicker"]').distpicker();
        
        
    })
</script>
@endsection
