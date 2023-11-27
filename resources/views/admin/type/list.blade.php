@extends('view_path::layouts.default')



@section('content')
<div class="container">
    <div class="row suda-row">
        
        <div class="page-heading">
            <h1 class="page-title">
                <i class="ion-person"></i>
                用户类型
            </h1>
            <button href="{{ admin_url('extension/user/type/add') }}" class="pop-modal btn btn-primary btn-sm pull-right">{{ trans('增加') }}</button>
        </div>
        
        @if($data_list->count()>0)
        <div class="col-md-12 col-md-offset-0 press_content">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                          <thead class="bg-light">
                            <tr>
                              <th>#</th>
                              <th>类型</th>
                              <th>状态</th>
                              <th>更新</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            @foreach ($data_list as $data)
                            <tr>
                              <td>{{ $data->id }}</td>
                              <td>
                                {{ $data->type_name }}
                                <a href="{{ url('x-'.$data->type_name.'/passport/login') }}" target="_blank" class="btn btn-light btn-xs" title="登录入口">入口</a>
                              </td>
                              <td>{{ $data->status?'启用':'禁用' }}</td>
                              <td>{{ $data->updated_at }}</td>
                              <td>
                                  <a href="{{ admin_url('extension/user/type/edit/'.$data->id) }}" class="pop-modal btn btn-light btn-xs" title="编辑" data-toggle="tooltip" data-placement="top">编辑</a>
                                  <a href="{{ admin_url('extension/user/type/delete/'.$data->id) }}" class="x-suda-pop-action btn btn-light btn-xs" action_id="{{ $data->id }}" title="删除" data-toggle="tooltip" data-placement="top">删除</a>
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
                </div>
            </div>
        </div>
        @else
        
            <x-suda::empty-block  empty="没有内容"  />
        
        @endif
    </div>
</div>
@endsection
