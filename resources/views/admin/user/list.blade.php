@extends('view_path::layouts.default')



@section('content')
<div class="container">
    <div class="row suda-row">
        
        <div class="page-heading">
            <h1 class="page-title">
                <i class="ion-person"></i>
                用户
            </h1>
            <button href="{{ admin_url('extension/user/user/add') }}" class="pop-modal btn btn-primary btn-sm pull-right">{{ trans('增加') }}</button>
        </div>
        
        @if($data_list->count()>0)
        <div class="col-md-12 col-md-offset-0 press_content">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table">
                          <thead class="bg-light">
                            <tr>
                              <th>类型</th>
                              <th>等级</th>
                              <th>用户</th>
                              <th>资料</th>
                              <th>状态</th>
                              <th>认证</th>
                              <th>注册</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($data_list)
                            @foreach ($data_list as $data)
                            <tr>
                              <td>{{ $data->userType?->type_name }}</td>
                              <td>{{ $data->userGrade?->grade_name }}</td>
                              <td>
                                @if($data->avatar)
                                <img src="{{ suda_image($data->avatar->media,['imageClass'=>'image_icon','url'=>true]) }}" style="max-width:36px;" data-toggle="popover" data-image="true">
                                @else
                                <img src="{{ suda_image(null,['imageClass'=>'image_icon','url'=>true]) }}" style="max-width:36px;" data-image="true">
                                @endif

                                @if($data->badge_star)
                                <i class="ion-star text-danger"></i>
                                @endif
                                {{ $data->username }}
                              </td>
                              <td>
                                  {{ $data->nickname }}<br>
                                  {{ $data->realname }}<br>
                                  {{ $data->email }}<br>
                                  {{ $data->phone }}
                              </td>
                              <td>{{ $data->status_text }}</td>
                              <td>
                                  {{ $data->badge_certificate }}
                              </td>
                              <td>{{ $data->created_at }}</td>
                              <td>
                                  <a href="{{ admin_url('extension/user/user/'.$data->id) }}" class="btn btn-primary btn-xs" title="授权管理" data-toggle="tooltip" data-placement="top"><i class="zly-eye-o"></i>&nbsp;查看</a>
                                  <a href="{{ admin_url('extension/user/user/edit/'.$data->id) }}" class="pop-modal btn btn-light btn-xs" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i>&nbsp;编辑</a>
                                  <a href="{{ admin_url('extension/user/user/password/'.$data->id) }}" class="pop-modal btn btn-warning btn-xs" data_id="{{ $data->id }}" title="设置" data-toggle="tooltip" data-placement="top">
                                    修改密码
                                  </a>
                                  <a href="{{ admin_url('extension/user/user/certificate/'.$data->id) }}" class="pop-modal btn btn-warning btn-xs"  data_id="{{ $data->id }}" title="设置" data-toggle="tooltip" data-placement="top">
                                    审核认证
                                  </a>
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
        @else
        
            <x-suda::empty-block  empty="没有内容"  />
        
        @endif
    </div>
</div>
@endsection
