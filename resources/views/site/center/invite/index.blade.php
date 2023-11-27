@extends('extension::layouts.app')



@section('content')
<div class="container">
    <div class="row">
        
        @include('extension::layouts.sidebar_profile')
        
        <div class="col-md-9">
            
            <div class="page-heading mb-3">
            
                <h1 class="page-title">
                    邀请
                </h1>
            
                <a href="{{ url('center/invite/add') }}" action="request" action_id="{{ $user->id }}" action_title="获取邀请码" class="x-suda-pop-action btn btn-primary btn-sm pull-right">获取邀请码</a>
                
            </div>

            {{-- <ul class="nav nav-tabs card-tabs">
                <li role="presentation" class="nav-item" >
                    <a class="nav-link @if(isset($tab_active) && $tab_active=='all') active @endif" href="{{ url('center/invite') }}">所有</a>
                </li>
            </ul> --}}
            
            <div class="card ">
                
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table  table-hover">
                          <thead class="bg-light">
                            <tr>
                              <th width="30%">邀请码</th>
                              <th width="40%">已邀请</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                              
                            @if($data_list->count()>0)
                                @if($data_list)
                                @foreach ($data_list as $data)
                                <tr>
                                    <td width="30%">
                                      <b>{{ $data->invite_code }}</b>
                                    </td>
                                    <td width="40%">
                                      @if($data->invite_user_id)
                                      <i>已邀请 {{ $data->invite_user->username }}</i>
                                      @else
                                      <i></i>
                                      @endif
                                    </td>
                                    <td>
                                        @if(!$data->invite_user_id)
                                        <a href="{{ url('center/invite/reset/'.$data->invite_code) }}" action="reset" action_id="{{ $data->invite_code }}" action_title="重置邀请码" class="x-suda-pop-action btn btn-primary btn-xs">重置邀请码</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            @endif
                          </tbody>
                      </table>
                      
                      @if(isset($filter_str))
            
                      <input type="hidden" id="filter_str" value="{{ $filter_str }}">
                  
                      {{ $data_list->appends($filter_arr)->links() }}
                      @else
                      {{ $data_list->links() }}
                      @endif
                      
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
@endsection

