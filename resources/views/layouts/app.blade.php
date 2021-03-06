<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pusher-key" content="{{ config("broadcasting.connections." . config('broadcasting.default') . '.key') }}">
    <meta name="pusher-port" content="{{ config("broadcasting.connections." . config('broadcasting.default') . '.options.port') }}">
    <meta name="pusher-encrypted" content="{{ config("broadcasting.connections." . config('broadcasting.default') . '.options.encrypted') }}">
    <meta name="pusher-ws-host" content="{{ config("broadcasting.connections." . config('broadcasting.default') . '.options.host') }}">

    <title>@yield('title', config('app.name', 'Laravel') )</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/backend') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('SIGNUP') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                                @if (auth()->user()->hasAnyPermission([
                                    'manage-events'
                                ]))
                                    <li class="nav-item d-flex align-items-center">
                                        <a class="nav-link" href="{{ route('admin.conversations.index') }}">Messages</a>
                                    </li>
                                @endif

                            @if (auth()->user()->hasAnyPermission([
                                    'manage-series'
                                ]))
                                    <li class="nav-item d-flex align-items-center">
                                        <a class="nav-link" href="{{ route('admin.series.index') }}">Series</a>
                                    </li>
                                @endif
                                @if (auth()->user()->hasAnyPermission([
                                    'manage-events'
                                ]))
                                    <li class="nav-item d-flex align-items-center">
                                        <a class="nav-link" href="{{ route('admin.events.index') }}">Events</a>
                                    </li>
                                @endif
                            </ul>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('change_password') }}">Change Password</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <script>
        window.AppUser = {!! json_encode([
            'user' => auth()->user()
        ]) !!};
    </script>
</body>
</html>
