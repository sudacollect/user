@extends('view_path::layouts.default')



@section('content')
<div class="container">
    <div class="row suda-row">
        
        <div class="page-heading">
            <h1 class="title">
                {{ $data->username }}
            </h1>
        </div>
        
        <div class="col-sm-12">
          
            <div class="card">
                <div class="card-body">
                  
                  <h2>Profile</h2>

                  <p>Username: {{ $data->username }}</p>
                  <p>Nickname: {{ $data->nickname }}</p>
                  <p>Email: {{ $data->email }}</p>
                  <p>Status: {{ $data->status_text }}</p>
                  <p>Certificate: {{ $data->badge_certificate }}</p>
                  <p>Created: {{ $data->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

