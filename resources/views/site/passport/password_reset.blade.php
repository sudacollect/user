@extends('extension::layouts.app_auth')

@section('content')
<div class="row">
    <div class="col-12">

        <ul class="nav nav-tabs card-tabs">
            <li class="nav-item" >
                <a  class="nav-link"  href="{{ url($prefix.'/passport/login') }}">{{ __('ext_user_lang::user.login') }}</a>
            </li>
            <li class="nav-item" >
                <a class="nav-link active" href="{{ url($prefix.'/passport/password/reset') }}">{{ __('ext_user_lang::user.reset_password') }}</a>
            </li>
        </ul>

        <div class="card card-with-tab">
            
            <div class="card-body py-5">
                {{-- <h5 class="card-title mb-3">{{ __('ext_user_lang::user.reset_password') }}</h5> --}}

                @if(isset($reset_send))
                    @if($reset_send=='reset_send')
                        <form class="form" role="form" method="POST" action="{{ url($prefix.'/passport/password/reset') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $reset_user->email }}">
                            <div class="mb-3">
                                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  required autofocus placeholder="填写新密码">
                                @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation"  required autofocus placeholder="确认密码">
                                  @if ($errors->has('password_confirmation'))
                                  <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                  </div>
                                    @endif
                            </div>
                    
                    
                    
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    重置密码
                                </button>
                            </div>
                    
                        </form>
                    @elseif($reset_send=='reset_success')
                        <h4 style="text-align:center;">密码已经重置成功</h4>
                        <br>
                    @else
                        <h4 style="text-align:center;">密码重置邮件已经发送至您的邮箱<br>请立即查收</h4>
                        <br>
                    @endif
                @else
                
                
                <form class="form" role="form" method="POST" action="{{ url($prefix.'/passport/password/reset') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('ext_user_lang::user.auth.email') }}">
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('ext_user_lang::user.btn.send_email') }}
                        </button>
                    </div>
                    
                </form>
                
                @endif
            </div>
            
        </div>
    </div>
</div>
@endsection
