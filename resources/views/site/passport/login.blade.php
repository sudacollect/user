@extends('extension::layouts.app_auth')


@section('content')
<div class="row container-login">
    <div class="col-12 login-box">
        <form class="form suda-login-form" role="form" method="POST" action="{{ url($prefix.'/passport/login') }}">
            <ul class="nav nav-tabs card-tabs">
                <li class="nav-item" >
                    <a  class="nav-link active"  href="{{ url($prefix.'/passport/login') }}">{{ __('ext_user_lang::user.login') }}</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" href="{{ url($prefix.'/passport/register') }}">{{ __('ext_user_lang::user.register') }}</a>
                </li>
            </ul>
        <div class="card card-with-tab mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">{{ __('ext_user_lang::user.login') }}</h5>
                
                    @csrf
                    
                    @if($login_name=='email')
                    <div class="mb-3">
                        
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="ion-person-outline"></i></span>
                            <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('ext_user_lang::user.auth.email') }}">
                            @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>

                    </div>
                    @endif

                    @if($login_name=='phone')
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="ion-phone-portrait-outline"></i></span>
                            <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus placeholder="{{ __('ext_user_lang::user.auth.phone') }}">
                            @if ($errors->has('phone'))
                            <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    @if($login_name=='username')
                    <div class="mb-3">
                        <input id="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus placeholder="{{ __('ext_user_lang::user.auth.username') }}">
                          @if ($errors->has('username'))
                        <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                        </div>
                        @endif
                        
                    </div>
                    @endif

                    <div class="mb-3">
                        
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="ion-lock-closed-outline"></i></span>
                          <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('ext_user_lang::user.auth.password') }}">
                          @if ($errors->has('password'))
                        <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                        </div>
                        @endif
                        </div>
                        
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" name="remember" type="checkbox" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            {{ __('ext_user_lang::user.auth.remember_login') }}
                        </label>
                    </div>
                    
                
            </div>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary btn-block btn-lg w-100 rounded-1">
                {{ __('ext_user_lang::user.btn.login') }}
            </button>
        </div>
        </form>

        <div class="mt-5 d-flex justify-content-between">
            <a class="btn btn-link ajaxPassword pull-right" style="color:#999;" href="{{ url($prefix.'/passport/password/reset') }}">
                {{ __('ext_user_lang::user.auth.forget_password') }}?
            </a>
            <a class="btn btn-link pull-left" title="{{ __('ext_user_lang::user.register') }}" href="{{ url($prefix.'/passport/register') }}">
                {{ __('ext_user_lang::user.register') }}
            </a>
        </div>

    </div>
</div>
@endsection