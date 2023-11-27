@extends('view_path::component.modal')



@section('content')
<div class="modal-body">
                    

<form class="form handle-form" role="form" method="POST" action="{{ admin_url('extension/user/grade/save') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $data->id }}">
    <input type="hidden" name="type_id" value="{{ $data->type_id }}">
    <div class="row mb-3 row{{ $errors->has('grade_name') ? ' has-error' : '' }}">
        
        <label for="grade_name" class="col-sm-3 col-form-label">
            等级
        </label>
        <div class="col-sm-6">
            <input type="text" name="grade_name" class="form-control" id="grade_name" placeholder="请填写类型(英文字母)" value="{{ $data->grade_name }}">
            @if ($errors->has('grade_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('grade_name') }}</strong>
                </span>
            @endif
        </div>
    
    </div>

    <div class="row mb-3 row{{ $errors->has('status') ? ' has-error' : '' }}">
        
        <label for="status" class="col-sm-3 col-form-label">
            状态
        </label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" @if($data->status==1) checked @endif>
                <label class="form-check-label" for="inlineRadio1">启用</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0" @if($data->status==0) checked @endif>
                <label class="form-check-label" for="inlineRadio2">停用</label>
            </div>
        </div>
    
    </div>
    
    
    <div class="row mb-3 row">
    <div class="offset-sm-3 col-sm-6">
        <button type="submit" class="btn btn-primary">{{ trans('提交保存') }}</button>
    </div>
    </div>
    
</form>
                    

</div>



<script type="text/javascript">
    $(document).ready(function(){
        
        $('.handle-form').ajaxform();
        
        
        $('div[data-toggle="distpicker"]').distpicker();
        
        
    })
</script>


@endsection
