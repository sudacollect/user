@extends('extension::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        @include('extension::layouts.sidebar')
        
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-8 offset-sm-0">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body pb-5 text-center">
                                    01
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body pb-5 text-center">
                                    02
                                </div>
                            </div>
                        </div>                        
                    </div>

                </div>
        
                <div class="col-sm-4 offset-sm-0">
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card-title mb-3 fw-bold">公告</div>
                            公告文字
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-3">
                                <img src="{{ extension_asset('ecdo','images/document.png') }}" class="card-img-top" >
                                <div class="card-body">
                                    <a href="https://docs.gtd.xyz" target="_blank" title="在线文档">
                                        <span class="card-title d-flex">在线文档<i class="ion-arrow-forward-circle-outline ms-auto"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
        
                </div>

            </div>
        </div>
        

    </div>
    
</div>
@endsection