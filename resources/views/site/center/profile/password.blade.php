@extends('extension::layouts.app')


@section('content')
<div class="container">
    <div class="row">
        
        @include('extension::layouts.sidebar_profile')
        
        <div class="col-sm-6">
            
            <div class="card">
                <div class="card-header">
                    <i class="ion-lock-open" title="@if($user->certified==5) 认证用户 @else 尚未认证 @endif"></i>&nbsp;修改密码
                </div>
                <div class="card-body">
                    
                    @if(session()->get('success'))
                    
                    <div class="alert alert-success" role="alert">密码已更新。下次登录使用新密码</div>
                    
                    @endif
                    <form class="form" role="form" method="POST" action="{{ url('center/profile/password') }}">
                        
                        {{ csrf_field() }}
                        
                        
                        
                        <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                          <label for="password" class="col-form-labelcol-form-label">
                              当前密码
                          </label>
                          <input type="password" name="password" class="form-control" value="" id="password" placeholder="请填写当前密码">
                              @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                        </div>
                        
                        
                        <div class="mb-3{{ $errors->has('new_password') ? ' has-error' : '' }}">
                          <label for="new_password" class="col-form-labelcol-form-label">
                              更新密码
                          </label>
                          <input type="password" name="new_password" class="form-control" value="" id="new_password" placeholder="请填写新密码">
                              @if ($errors->has('new_password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('new_password') }}</strong>
                                  </span>
                              @endif
                        </div>
                        
                        
                        <div class="mb-3{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                          <label for="new_password_confirmation" class="col-form-labelcol-form-label">
                              确认新密码
                          </label>
                          <input type="password" name="new_password_confirmation" class="form-control" value="" id="new_password_confirmation" placeholder="请确认新密码">
                              @if ($errors->has('new_password_confirmation'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                  </span>
                              @endif
                        </div>

                        
                        
                        
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">{{ __('ext_user_lang::user.btn.submit') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>



@endsection
