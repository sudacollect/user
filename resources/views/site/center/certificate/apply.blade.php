@extends('extension::component.modal')



@section('content')
<div class="modal-body">
        
@if($apply)

<p>
  已有资料正在认证，请稍后再提交变更。
</p>

@else
<form class="form handle-form" role="form" method="POST" action="{{ url('center/certificate/apply') }}">
    @csrf

    <div class="mb-3{{ $errors->has('certi_type') ? ' has-error' : '' }} ">
        
      <label for="certi_type" class="col-form-label">
          认证类型
      </label>
      <select name="certi_type" class="form-select">
        <option value="0">请选择类型</option>
        <option value="personal" @if($item?->certi_type == 'personal') selected @endif>个人</option>
        <option value="team" @if($item?->certi_type == 'team') selected @endif>团队</option>
        <option value="company" @if($item?->certi_type == 'company') selected @endif>企业</option>
        <option value="organization" @if($item?->certi_type == 'organization') selected @endif>公益组织</option>
        <option value="edu" @if($item?->certi_type == 'edu') selected @endif>教育机构</option>
      </select>
      
    </div>
    
    <div class="mb-3{{ $errors->has('certi_name') ? ' has-error' : '' }} ">
        
      <label for="certi_name" class="col-form-label">
          认证名称
      </label>
      <input type="text" name="certi_name" class="form-control" value="{{ $item?->certi_name }}" placeholder="认证名称">
      <span class="help-block">
          请填写个人姓名或者公司组织名称
      </span>
      
    </div>
    
    <div class="mb-3{{ $errors->has('certi_no') ? ' has-error' : '' }} ">
        
      <label for="certi_no" class="col-form-label">
          认证代码
      </label>
      <input type="text" name="certi_no" class="form-control" value="{{ $item?->certi_no }}" placeholder="认证代码">
      <span class="help-block">
          请填写个人身份证代码或者公司组织代码
      </span>
      
    </div>

    <div class="mb-3">
      
        <button type="submit" class="btn btn-primary">{{ __('ext_user_lang::user.btn.submit') }}</button>
      
    </div>
    
</form>
@endif
                    


</div>

<script type="text/javascript">
    $(document).ready(function(){
        
      $('.handle-form').ajaxform();
        
    })
</script>


@endsection

