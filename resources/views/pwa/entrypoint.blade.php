@extends('layouts.entrypoint')

@push('assets.preload')
    <link rel="preload" as="style" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush

@push('assets')
    <link rel="icon" type="image/png" href="{{ asset('icons/icon.48x48.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush

@push('styles')
    <style>
        .app__overlay {
            background: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            transition: opacity 500ms, width 0ms 500ms, height 0ms 500ms;
        }

        .app__shell + .app__overlay {
            opacity: 0;
            width: 0;
            height: 0;
        }
    </style>
@endpush

@section('body.end')
    <div id="overlay" class="app__overlay"></div>
@endsection
