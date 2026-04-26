<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale'))">
    <head>
        @yield('head.start')
        <title>@yield('title', config('app.name'))</title>
        @section('meta')
            <meta charset="@yield('charset', 'UTF-8')"/>
            <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1')"/>
            @stack('meta')
        @show
        @section('preload')
            {{-- Nothing default here yet --}}
            @stack('preload')
        @show
        @section('styles')
            <style>{{ config('pwa.styles') }}</style>
            @stack('styles')
        @show
        @yield('head.end')
    </head>
    <body @pwaContainer()>
        @yield('body.start')
        <div @pwaShell()></div>
        <div @pwaOverlay()></div>
        @yield('body.end')
        @section('scripts')
            <script @pwaScript()></script>
            @stack('scripts')
        @show
    </body>
</html>
