@extends('extension::layouts.app_auth')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                注册完成
            </div>
            <div class="card-body py-5">
                
                <h4>注册邮箱 {{ $email }}</h4>
                <p>请查收邮件并完成注册确认</p>
                
            </div>
            
            <div class="card-footer bt-white">
                
                <span class="help-block">1. 如果注册邮箱无法正常收取邮件,请更换邮箱重新注册</span>
                <span class="help-block">2. 如果无法收到邮件，请检查是否在垃圾箱内</span>
                
            </div>
        </div>
    </div>
</div>
@endsection
