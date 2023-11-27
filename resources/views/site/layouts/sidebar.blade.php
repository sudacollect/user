        <div class="col-sm-2 col-md-2 offset-sm-0">
            
            <div class="card mb-3">
                <div class="card-header bg-white">
                    控制台
                </div>
                <div class="card-body card-body-sidebar">
                    <ul class="sidebar">
                        <li @if($sidebar_active=='dashboard') class="active" @endif>
                            <a href="{{ url('center') }}"><i class="ion-settings-outline"></i>控制台</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            
            
            @if(isset($user_side_items))

            @foreach($user_side_items as $item)
            <div class="card mb-3">
                <div class="card-header bg-white">
                    {{ $item['name'] }}
                </div>
                @if(isset($item['children']))
                <div class="card-body card-body-sidebar">
                    <ul class="sidebar">
                        @foreach($item['children'] as $child)
                        <li>
                            <a href="{{ $child['link'] }}"><i class="{{ $child['icon'] }}"></i>{{ $child['name'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            @endforeach

            @endif
            
        </div>