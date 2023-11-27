@extends('extension::component.modal')



@section('content')
<div class="modal-body">

<form class="form handle-form" role="form" method="POST" action="#">
    @csrf

    
    <div class="mb-3">
        
      <div>
        {{ $serial }}
      </div>
      
    </div>
    
</form>

</div>

{{-- <script type="text/javascript">
    $(document).ready(function(){
        
      $('.handle-form').ajaxform();
        
    })
</script> --}}


@endsection

