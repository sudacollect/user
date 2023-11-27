@extends('view_path::component.modal',['modal_size'=>'xl'])



@section('content')
<div class="modal-body">
                    

    <form class="form handle-ajaxform" role="form" method="POST" action="{{ admin_url('extension/user/user/certificate/save') }}">
        @csrf                  
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="row">
            <div class="col">
                <h4>当前认证</h4>
                @if($item)
                <div class="mb-3{{ $errors->has('certi_type') ? ' has-error' : '' }} ">
        
                    <label for="certi_type" class="col-form-label">
                        认证类型
                    </label>
                    <div>
                    {{ $item?->certi_type }}
                    </div>

                </div>
                  
                <div class="mb-3{{ $errors->has('certi_name') ? ' has-error' : '' }} ">
                    
                    <label for="certi_name" class="col-form-label">
                        认证名称
                    </label>
                    <input type="text" readonly class="form-control form-control-plaintext" value="{{ $item?->certi_name }}" placeholder="认证名称">
                    
                </div>
                  
                <div class="mb-3{{ $errors->has('certi_no') ? ' has-error' : '' }} ">
                    
                    <label for="certi_no" class="col-form-label">
                        认证代码
                    </label>
                    <input type="text" readonly class="form-control form-control-plaintext" value="{{ $item?->certi_no }}" placeholder="认证代码">
                    
                </div>
                  
                <div class="mb-3{{ $errors->has('start_date') ? ' has-error' : '' }} ">
                    
                    <label for="start_date" class="col-form-label">
                        有效期
                    </label>
                    <div>
                    {{ $item?->start_date }} ~ {{ $item?->end_date }}
                    </div>
                
                </div>
                @else
                当前无认证信息
                @endif
            </div>
            <div class="col border-end">
                <h4>申请变更</h4>
                <div class="mb-3{{ $errors->has('certi_type') ? ' has-error' : '' }} ">
        
                    <label for="certi_type" class="col-form-label">
                        认证类型
                    </label>
                    <select name="certi_type" class="form-select">
                      <option value="0">请选择类型</option>
                      <option value="personal" @if($item_apply?->certi_type == 'personal') selected @endif>个人</option>
                      <option value="team" @if($item_apply?->certi_type == 'team') selected @endif>团队</option>
                      <option value="company" @if($item_apply?->certi_type == 'company') selected @endif>企业</option>
                      <option value="organization" @if($item_apply?->certi_type == 'organization') selected @endif>公益组织</option>
                      <option value="edu" @if($item_apply?->certi_type == 'edu') selected @endif>教育机构</option>
                    </select>
                    
                </div>
                  
                <div class="mb-3{{ $errors->has('certi_name') ? ' has-error' : '' }} ">
                    
                    <label for="certi_name" class="col-form-label">
                        认证名称
                    </label>
                    <input type="text" name="certi_name" class="form-control" value="{{ $item_apply?->certi_name }}" placeholder="认证名称">
                    <span class="help-block">
                        请填写个人姓名或者公司组织名称
                    </span>
                
                </div>
                  
                <div class="mb-3{{ $errors->has('certi_no') ? ' has-error' : '' }} ">
                    
                    <label for="certi_no" class="col-form-label">
                        认证代码
                    </label>
                    <input type="text" name="certi_no" class="form-control" value="{{ $item_apply?->certi_no }}" placeholder="认证代码">
                    <span class="help-block">
                        请填写个人身份证代码或者公司组织代码
                    </span>
                
                </div>
                  
                <div class="mb-3{{ $errors->has('start_date') ? ' has-error' : '' }} ">
                    
                    <label for="start_date" class="col-form-label">
                        有效期
                    </label>
                    <div class="input-group">
                    <input type="text" name="start_date" data-toggle="datetimepicker" class="form-control" value="{{ $item_apply?->start_date }}" placeholder="开始日期">
                    <span class="input-group-text">~</span>
                    <input type="text" name="end_date" data-toggle="datetimepicker" class="form-control" value="{{ $item_apply?->end_date }}" placeholder="结束日期">
                    </div>
                
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">{{ trans('提交保存') }}</button>
                </div>
            </div>
            
        </div>
        
    </form>
                    

</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('.handle-ajaxform').ajaxform();
        
        
        $('div[data-toggle="distpicker"]').distpicker();
        
        $('[data-toggle="datetimepicker"]').datetimepicker({
            format: 'YYYY-MM-DD',
            locale:'zh-cn',
            showClear:false,
            sideBySide:false,
            useCurrent:'day',
        });
        
    })
</script>

@endsection
