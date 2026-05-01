<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale'))" hx-headers='{"X-Csrf-Token": "{{ csrf_token() }}"}'>
    <head>
        @yield('head.start')
        <title>@yield('title', config('app.name'))</title>
        @section('meta')
            <meta charset="@yield('charset', 'UTF-8')"/>
            <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1')"/>
            @stack('meta')
        @show
        @section('assets.preload')
            @stack('assets.preload')
        @show
        @section('assets')
            <link rel="manifest" type="application/manifest+json" href="{{ $manifest }}"/>
            @stack('assets')
        @show
        @section('styles')
            @stack('styles')
        @show
        @yield('head.end')
    </head>
    <body {{ attributes(config('pwa.attributes.container')) }}>
        @yield('body.start')
        <div {{ attributes(config('pwa.attributes.shell')) }}></div>
        @yield('body.end')
        @section('scripts')
            <script {{ attributes(config('pwa.attributes.script')) }}></script>
            @stack('scripts')
        @show
    </body>
</html>
