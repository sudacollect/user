@extends('view_path::component.modal')



@section('content')
<div class="modal-body">
                    

    <form class="form handle-ajaxform" role="form" method="POST" action="{{ admin_url('extension/user/user/password/save') }}">
        @csrf
            
            <input type="hidden" name="id" value="{{ $data->id }}">

        
        <div class="row mb-3{{ $errors->has('new_password') ? ' has-error' : '' }}">
            
            <label for="new_password" class="col-sm-3 col-form-label">
                新密码
            </label>
            <div class="col-sm-6">
                <input type="text" name="new_password" class="form-control" id="new_password" placeholder="密码">
                @if ($errors->has('new_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                @endif
            </div>
        
        </div>

        <div class="row mb-3{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
            
            <label for="confirm_password" class="col-sm-3 col-form-label">
                确认新密码
            </label>
            <div class="col-sm-6">
                <input type="text" name="confirm_password" class="form-control" id="confirm_password" placeholder="密码">
                @if ($errors->has('confirm_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('confirm_password') }}</strong>
                    </span>
                @endif
            </div>
        
        </div>
                      
        <div class="form-group">
        <div class="offset-sm-3 col-sm-6">
            <button type="submit" class="btn btn-primary">{{ __('ext_user_lang::user.btn.submit') }}</button>
        </div>
        </div>
        
    </form>
                    

</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('.handle-ajaxform').ajaxform();
        
        
        $('div[data-toggle="distpicker"]').distpicker();
        
        
        
    })
</script>

@endsection
