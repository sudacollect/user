@extends('extension::layouts.app')



@section('content')
<div class="container">
    <div class="row">
        
        @include('extension::layouts.sidebar_profile')
        
        <div class="col-sm-10">
            
            <div class="page-heading mb-3">
            
                <h1 class="page-title">
                    认证
                </h1>
            
                <a href="{{ url('center/certificate/apply') }}" class="pop-modal btn btn-primary btn-sm pull-right">申请授权变更</a>
                
            </div>

            
            <div class="card">
                
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table  table-hover">
                          <thead class="bg-light">
                            <tr>
                              <th>类型</th>
                              <th>认证</th>
                              <th>token</th>
                              <th>状态</th>
                            </tr>
                          </thead>
                          <tbody>
                              
                                @if($item)
                                
                                <tr>
                                    <td>
                                        <b>{{ $item->certi_type_name }}</b>
                                        </td>
                                    <td>
                                        名称：{{ $item->certi_name }}<br>
                                        编号：{{ $item->certi_no }}<br>
                                        期限：{{ $item->start_date }} ~ {{ $item->end_date }}<br>
                                        产品：{{ $item->certi_product }}
                                    </td>
                                    <td>
                                        <button href="{{ url('center/token/show/'.$item->id) }}" class="pop-modal btn btn-primary btn-xs">查看 token</button>
                                        <a href="{{ url('center/token/reset/'.$item->id) }}" class="x-suda-pop-action btn btn-danger btn-xs" action_title="重置 token?" action="reset" action_id="{{ $item->id }}" title="重置token" data-toggle="tooltip" data-placement="top">重置 token</a>
                                    </td>
                                    
                                    <td>
                                        @if($item->status==1)
                                        已生效
                                        @else
                                        未生效
                                        @endif
                                    </td>
                                    
                                </tr>
                                
                                @endif
                            
                          </tbody>
                      </table>
                      
                      
                      
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
@endsection

