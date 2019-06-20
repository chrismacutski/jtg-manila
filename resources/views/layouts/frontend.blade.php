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
        @include('frontend.nav')
        <main>
            @yield('content')
        </main>

        @include('frontend.partials.home.footer', [
            'event_img' => '/images/jtg-manila-map.png'
        ])

        @include('frontend.partials.loader', [
            'img' => '/images/jtg-bg.jpg'
        ])

        <window-controller :hide-queue-position="{{ json_encode(config('chat.hide_queue_position')) }}"
                           :author="{{ json_encode('chatter') }}"></window-controller>
    </div>
</body>
</html>
