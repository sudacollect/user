@extends('extension::layouts.app')



@section('content')
<div class="container">
    <div class="row">
        
        @include('extension::layouts.sidebar')
        
        
        
        
        <div class="col-md-10">
            
            <div class="page-heading mb-3">
            
                <h1 class="page-title">
                    Token
                </h1>
            
                
                
            </div>

            <ul class="nav nav-tabs card-tabs">
                <li role="presentation" class="nav-item" >
                    <a class="nav-link @if(isset($tab_active) && $tab_active=='all') active @endif" href="{{ url('center/tokens') }}">所有</a>
                </li>
            </ul>
            
            <div class="card card-with-tab">
                
                <div class="card-body">
                    @if($data_list->count()>0)
                    <div class="table-responsive">
                      <table class="table  table-hover">
                          <thead class="bg-light">
                            <tr>
                              <th>token</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                              
                            
                                
                                @foreach ($data_list as $data)
                                <tr>
                                  <td>
                                      <button href="{{ url('center/token/show/'.$data->id) }}" class="pop-modal btn btn-primary btn-xs">查看 token</button>
                                  </td>
                                  <td>
                                      <a href="{{ url('center/token/reset/'.$data->id) }}" class="x-suda-pop-action btn btn-danger btn-xs" action_title="重置 token?" action="reset" action_id="{{ $data->id }}" title="重置token" data-toggle="tooltip" data-placement="top">重置 token</a>
                                  </td>
                                </tr>
                                @endforeach
                                
                            

                          </tbody>
                      </table>
                      
                      @if(isset($filter_str))
            
                      <input type="hidden" id="filter_str" value="{{ $filter_str }}">
                  
                      {{ $data_list->appends($filter_arr)->links() }}
                      @else
                      {{ $data_list->links() }}
                      @endif
                      
                    </div>

                    @else

                    <x-suda::empty-block empty="需要完成认证才能获取token" :card=false/>

                    @endif
                </div>
                
            </div>
        </div>
        
    </div>
</div>
@endsection

