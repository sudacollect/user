        <div class="col-sm-2 col-md-2 offset-sm-0">
            
            
            <div class="card mb-3">
                <div class="card-header bg-white">
                    资料
                </div>
                <div class="card-body card-body-sidebar">
                    <ul class="sidebar">
                        <li @if($sidebar_active=='profile') class="active" @endif>
                            <a href="{{ url('center/profile') }}"><i class="ion-person-outline"></i>资料</a>
                        </li>
                        
                        <li @if($sidebar_active=='password') class="active" @endif>
                            <a href="{{ url('center/profile/password') }}"><i class="ion-lock-closed-outline"></i>密码</a>
                        </li>

                        <li @if($sidebar_active=='certificate') class="active" @endif>
                            <a href="{{ url('center/certificate') }}"><i class="ion-business-outline"></i>认证</a>
                        </li>

                        <li @if($sidebar_active=='invite') class="active" @endif>
                            <a href="{{ url('center/invite') }}"><i class="ion-leaf-outline"></i>邀请</a>
                        </li>

                    </ul>
                </div>
            </div>

            {{-- <div class="card mb-3">
                <div class="card-header bg-white">
                    下载
                </div>
                <div class="card-body card-body-sidebar">
                    <ul class="sidebar">
                        <li>
                            <a href="{{ url('extensions') }}" target="_blank"><i class="ion-reader"></i>更多应用</a>
                        </li>
                    </ul>
                </div>
            </div>
             --}}
        </div>