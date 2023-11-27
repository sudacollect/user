<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name=robots content=noindex,nofollow>
    <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if(isset($sdcore)) {{ metas($sdcore) }} @else {{ metas() }} @endif</title>

    <link rel="stylesheet" href="{{ suda_asset('css/app.css') }}">
    
    <link rel="stylesheet" href="{{ asset('extensions/user/assets/css/style.css') }}">
    
    @stack('styles')
    
    <!-- Scripts -->
    <script>
        window.suda = {csrfToken:"{{ csrf_token() }}"}
        suda.meta = { csrfToken: "{{csrf_token()}}",url:"{{url('/')}}" }
    </script>
    
    
    
</head>
<body>
    <div id="app" class="suda-app">
        
        <nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark px-3">
            <div class="navbar-header d-flex">

                <!-- Collapsed Hamburger -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" >
                    {{ config('app.name', 'Suda') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-menu">
                    @if (Auth::guard('client')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/center') }}">
                        <i class="ion-speedometer"></i>&nbsp;控制台
                        </a>
                    </li>
                    
                    @if(isset($user_navi_items))
                    
                    @foreach($user_navi_items as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $item['link'] }}">
                            <i class="{{ $item['icon'] }}"></i>&nbsp;{{ $item['name'] }}
                        </a>
                    </li>
                    @endforeach
                    @endif
                    
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav ms-auto">

                    <!-- Authentication Links -->
                    @if (Auth::guard('client')->guest())
                        <li class="nav-item"><a class="nav-link" href="{{ url($prefix.'/passport/login') }}">{{ __('ext_user_lang::user.login') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url($prefix.'/passport/register') }}">{{ __('ext_user_lang::user.register') }}</a></li>
                    @else
                        
                        
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" id="dropdownMenuButton"  aria-haspopup="true" role="button">
                                @if(Auth::guard('client')->user()->badge_certificate) <span class="badge rounded-pill text-bg-success"><i class="ion-medal me-1"></i>已认证</span> @else <span class="badge badge-pill bg-light text-dark">未认证</span> @endif
                                {{ Auth::guard('client')->user()->username }} 设置
                            </a>
                            <div class="dropdown-menu dropdown-menu-dark dropdown-menu-sm-end" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ url('center/profile') }}">
                                    <i class="ion-person text-light"></i>&nbsp;{{__('ext_user_lang::user.auth.account')}}
                                </a>
                                <a class="dropdown-item" href="{{ url('https://docs.gtd.xyz') }}" target="_blank">
                                    <i class="ion-document-text text-light"></i>&nbsp;文档
                                </a>
        
                                <a class="dropdown-item" href="{{ url('/help') }}">
                                    <i class="ion-help-buoy text-light"></i>&nbsp;帮助
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="ion-exit text-light"></i>&nbsp;退出
                                </a>

                                <form id="logout-form" action="{{ url($prefix.'/passport/logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
                
            </div>
        </nav>
        <div class="app-content" style="padding:62px 0;">
        @yield('content')
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ suda_asset('js/app.js') }}"></script>
    
    @stack('scripts')
    
</body>
</html>
