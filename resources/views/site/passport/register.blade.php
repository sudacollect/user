@extends('extension::layouts.app_auth')

@section('content')
<div class="row container-register">
    <div class="col-12">
        <form class="form" role="form" method="POST" action="{{ url($prefix.'/passport/register') }}">
            @csrf
            <ul class="nav nav-tabs card-tabs">
                <li class="nav-item" >
                    <a  class="nav-link"  href="{{ url($prefix.'/passport/login') }}">{{ __('ext_user_lang::user.login') }}</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link active" href="{{ url($prefix.'/passport/register') }}">{{ __('ext_user_lang::user.register') }}</a>
                </li>
            </ul>
            <div class="card card-with-tab mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('ext_user_lang::user.register') }}</h5>

                        <div class="mb-3">
                            <label for="username" class="col-form-label">{{ __('ext_user_lang::user.auth.username') }}</label>
                            <input id="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required placeholder="{{ __('ext_user_lang::user.placeholder.username') }}">

                            @if ($errors->has('username'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </div>
                            @endif

                        </div>

                        <div class="mb-3">
                            <label for="nickname" class="col-form-label">{{ __('ext_user_lang::user.auth.nickname') }}</label>
                            <input id="nickname" type="text" class="form-control {{ $errors->has('nickname') ? ' is-invalid' : '' }}" name="nickname" value="{{ old('nickname') }}" required placeholder="{{ __('ext_user_lang::user.placeholder.nickname') }}">

                            @if ($errors->has('nickname'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('nickname') }}</strong>
                                </div>
                            @endif

                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="col-form-label">{{ __('ext_user_lang::user.auth.email') }}</label>
                            <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ __('ext_user_lang::user.placeholder.email') }}">

                            @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif

                        </div>

                        @if($login_name == 'phone')
                        <div class="mb-3">
                            <label for="phone" class="col-form-label">{{ __('ext_user_lang::user.auth.phone') }}</label>
                            <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required placeholder="{{ __('ext_user_lang::user.placeholder.phone') }}">

                            @if ($errors->has('phone'))
                            <div class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                            </div>
                            @endif

                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="password" class="col-form-label">{{ __('ext_user_lang::user.auth.password') }}</label>
                            
                            <div class="input-group {{ $errors->has('password') ? ' is-invalid' : '' }}">
                                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('ext_user_lang::user.placeholder.password') }}">
                                
                                <div class="input-group-append">
                                    <button class="btn btn-light" type="button" id="password-eye"><i class="ion-eye-off"></i></button>
                                </div>

                                </div><!-- /input-group -->

                                @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                                @endif

                        </div>
                        
                        @if(isset($use_invite_code) && $use_invite_code)
                        
                        <div class="mb-3">
                            <label for="invite_code" class="col-form-label">{{ __('ext_user_lang::user.auth.invite_code') }}</label>
                            <input id="invite_code" type="text" class="form-control {{ $errors->has('invite_code') ? ' is-invalid' : '' }}" name="invite_code" value="@if(isset($invite_code)){{ $invite_code }}@endif" placeholder="{{ __('ext_user_lang::user.placeholder.invite_code') }}">

                            @if ($errors->has('invite_code'))
                                <div class="invalid-feedback">
                                        <strong>{{ $errors->first('invite_code') }}</strong>
                                </div>
                                @endif
                            
                        </div>
                        
                        @endif
                    
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary btn-block btn-lg w-100 rounded-1">
                    {{ __('ext_user_lang::user.btn.register') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function(){
        
        $('#password-eye').on('click',function(e){
            
            if($(this).hasClass('open')){
                
                $(this).removeClass('open');
                $(this).find('i').attr('class','ion-eye-off');
                
                $('#password').attr('type','password');
            }else{
                $(this).addClass('open');
                $(this).find('i').attr('class','ion-eye');
                $('#password').attr('type','text');
            }
            
        })
        
    })
</script>

@endpush
