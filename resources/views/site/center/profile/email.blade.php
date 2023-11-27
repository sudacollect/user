@extends('extension::component.modal')



@section('content')
<div class="modal-body">
        

<form class="handle-form" id="change-email-form" role="form" method="POST" action="{{ url('center/profile/email') }}">
  @csrf
                        
                      
  <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
      
    <label for="email" class="col-form-label">
        更换邮箱
    </label>
    
    <div class="input-group">
      <input id="email" type="text" class="form-control" name="email" value="" required placeholder="请填写新邮箱">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="button" id="send-verify-code">发送验证码</button>
      </span>
    </div><!-- /input-group -->
    
  </div>
  
  
  <div class="mb-3{{ $errors->has('verify_code') ? ' has-error' : '' }}">
      
    <label for="verify_code" class="col-form-label">
        验证码
    </label>

    <input type="text" name="verify_code"  class="form-control" value="" id="verify_code" placeholder="邮箱验证码">

    
  </div>
  

  
  
  <div class="mb-3">
      <button type="submit" class="btn btn-primary">确认更换</button>
  </div>

  
</form>
                    


</div>

<script type="text/javascript">
    $(document).ready(function(){
        
      $('.handle-form').ajaxform();
        
        $('#send-verify-code').on('click',function(e){
            
            e.preventDefault();
            
            
            $.ajax({
                url: suda.link('center/profile/email/sendcode'),
                type: 'POST',
                dataType: 'json',
                data: {
                    email: $('#change-email-form').find('#email').val(),
                    _token: suda.data('csrfToken')
                },
                error: function(xhr) {
                    var error = xhr.responseJSON
                    alert(error.response_msg);
                },
                success: function(res) {
                    alert('验证码已经发送');
                },
            });
            
        });
        
    })
</script>


@endsection
