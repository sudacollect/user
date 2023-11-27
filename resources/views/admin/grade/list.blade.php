@extends('view_path::layouts.default')



@section('content')
<div class="container">
    <div class="row suda-row">
        
        <div class="page-heading">
            <h1 class="page-title">
                <i class="ion-person"></i>
                等级
            </h1>
            <button href="{{ admin_url('extension/user/grade/add') }}" class="pop-modal btn btn-primary btn-sm pull-right">{{ trans('增加') }}</button>
        </div>
        
        
        <div class="col-md-12 col-md-offset-0 press_content">
            
            <ul class="nav nav-tabs card-tabs">
              <li class="nav-item">
                <a class="nav-link @if($active=='list') bg-white active @endif" href="{{ admin_url('extension/user/grades') }}">全部</a>
              </li>

              @if($types->count()>0)
              @foreach($types as $type)
              <li class="nav-item">
                <a class="nav-link @if($active==$type->type_name) bg-white active @endif" href="{{ admin_url('extension/user/grades/'.$type->type_name) }}">{{ $type->type_name }}</a>
              </li>
              @endforeach
              @endif
            </ul>

            <div class="card card-with-tab">
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                          <thead class="bg-light">
                            <tr>
                              <th>类型</th>
                              <th>等级</th>
                              <th>更新</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($data_list)
                            @foreach ($data_list as $data)
                            <tr>
                              <td>{{ $data->userType?->type_name }}</td>
                              <td>
                                {{ $data->grade_name }}
                              </td>
                              <td>{{ $data->updated_at }}</td>
                              <td>
                                  <a href="{{ admin_url('extension/user/grade/edit/'.$data->id) }}" class="pop-modal btn btn-light btn-xs" title="编辑" data-toggle="tooltip" data-placement="top">编辑</a>
                                  <a href="{{ admin_url('extension/user/grade/delete/'.$data->id) }}" class="x-suda-pop-action btn btn-light btn-xs" action_id="{{ $data->id }}" title="删除" data-toggle="tooltip" data-placement="top">删除</a>
                              </td>
                            </tr>
                            @endforeach
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
