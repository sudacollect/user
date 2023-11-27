@extends('view_path::component.modal')



@section('content')
<div class="modal-body">
                    

<form class="form handle-form" role="form" method="POST" action="{{ admin_url('extension/user/type/save') }}">
    @csrf

    <div class="row mb-3 row{{ $errors->has('type_name') ? ' has-error' : '' }}">
        
        <label for="type_name" class="col-sm-3 col-form-label">
            类型
        </label>
        <div class="col-sm-6">
            <input type="text" name="type_name" class="form-control" id="type_name" placeholder="请填写类型(英文字母)">
            @if ($errors->has('type_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('type_name') }}</strong>
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
                <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" checked>
                <label class="form-check-label" for="inlineRadio1">启用</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
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
