@extends('extension::layouts.app_auth')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            
            <div class="card-body py-5">
                
                @if(isset($register_checked))
                
                <h4 style="text-align:center;">Confirmed!</h4>
                
                
                @else
                
                <h4 style="text-align:center" class="mb-4">注册邮箱 {{ $register_user->email }}</h4>
                
                
                <form class="" role="form" method="POST" action="{{ url($prefix.'/passport/register/check') }}">
                    @csrf

                    <input type="hidden" name="email" value="{{ $register_user->email }}" >
                    <input type="hidden" name="token" value="{{ $register_user->token }}" >
                    
                    <div class="text-center{{ $errors->has('register') ? ' has-error' : '' }}">
                        <label for="submit" class="col-form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-warning">
                            点击确认邮箱
                        </button>
                        
                        @if ($errors->has('register'))
                            <span class="help-block">
                                <strong>{{ $errors->first('register') }}</strong>
                            </span>
                        @endif
                    </div>
                </form>
                
                @endif
            </div>
            
            <div class="card-footer bg-white">
                
                <span class="help-block">已经完成确认? 可直接去 <a href="{{ url($prefix.'/passport/login') }}">登录</a></span>
                
            </div>
        </div>
    </div>
</div>
@endsection
