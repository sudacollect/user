@extends('extension::layouts.app')


@section('content')
<div class="container">
    <div class="row">
        
        @include('extension::layouts.sidebar_profile')
        
        <div class="col-sm-5">
            
            <div class="card">
                <div class="card-header">
                    
                    <i class="ion-person-outline"></i>&nbsp;个人资料
                    
                </div>
                <div class="card-body">
                    
                    @if(session()->get('success'))
                    
                    <div class="alert alert-success col-sm-6 offset-sm-3" role="alert">更新完成</div>
                    
                    @endif
                    
                    <form class="form" role="form" method="POST" action="{{ url('center/profile/update') }}">
                        
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="mb-3{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="inputEmail3" class="col-form-labelcol-form-label">
                                    用户名
                                    </label>
                                    <input type="text" readonly class="form-control form-control-plaintext" value="{{ $user->username }}" placeholder="用户名">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="inputEmail3" class="col-form-labelcol-form-label">
                                        邮箱
                                    </label>
                                    <div class="input-group">
                                        <input id="email" type="text" class="form-control" disabled name="email" value="{{ $user->email }}" required placeholder="请填写邮箱">
                                        <span class="input-group-append">
                                        <button href="{{ url('center/profile/email') }}" class="pop-modal btn btn-primary" type="button" id="change-email">更换邮箱</button>
                                        </span>
                                    </div><!-- /input-group -->
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="mb-3{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="inputEmail3" class="col-form-labelcol-form-label">
                                        手机号
                                    </label>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" id="phone" placeholder="手机号">
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
        
                                <div class="mb-3{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                    <label for="nickname" class="col-form-labelcol-form-label">
                                        昵称
                                    </label>
                                    <input type="text" name="nickname" class="form-control" value="{{ $user->nickname }}" placeholder="昵称">
                                    @if ($errors->has('nickname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                    @endif
                                    <span class="help-block">页面显示昵称</span>
                                </div>
                                
                                <div class="mb-3{{ $errors->has('gender') ? ' has-error' : '' }}">
                                  <label for="gender" class="col-form-labelcol-form-label">
                                      性别
                                  </label>
                                  <select name="gender" class="form-select">
                                        <option value="secret" @if($user->gender=='secret') selected @endif>保密</option>
                                        <option value="male" @if($user->gender=='male') selected @endif>男</option>
                                        <option value="female" @if($user->gender=='female') selected @endif>女</option>
                                        <option value="unknown" @if($user->gender=='unknown') selected @endif>其他</option>
                                        
                                    </select>
                                    
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="mb-3{{ $errors->has('link_wechat') ? ' has-error' : '' }}">
                                  <label for="link_wechat" class="col-form-labelcol-form-label">
                                      微信号
                                  </label>
                                  <input type="text" name="link_wechat" class="form-control" value="{{ $user->link_wechat }}" placeholder="微信号" />
                                </div>
                                <div class="mb-3{{ $errors->has('link_qq') ? ' has-error' : '' }}">
                                    <label for="link_qq" class="col-form-labelcol-form-label">
                                        QQ
                                    </label>
                                    <input type="text" name="link_qq" class="form-control" value="{{ $user->link_qq }}" placeholder="QQ" />
                                </div>
                                <div class="mb-3{{ $errors->has('link_github') ? ' has-error' : '' }}">
                                    <label for="link_github" class="col-form-labelcol-form-label">
                                        Github
                                    </label>
                                    <input type="text" name="link_github" class="form-control" value="{{ $user->link_github }}" placeholder="Github" />
                                </div>
                                <div class="mb-3{{ $errors->has('link_twitter') ? ' has-error' : '' }}">
                                    <label for="link_twitter" class="col-form-labelcol-form-label">
                                        Twitter
                                    </label>
                                    <input type="text" name="link_twitter" class="form-control" value="{{ $user->link_twitter }}" placeholder="Twitter" />
                                </div>
        
                                <div class="mb-3 ">
                                    <button type="submit" class="btn btn-primary">{{ __('ext_user_lang::user.btn.save') }}</button>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-control-static">
                                    @uploadCroppie('user',$user->avatar)
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        

                    </form>
                    
                </div>
            </div>

        </div>
    </div>
    
</div>

@endsection
