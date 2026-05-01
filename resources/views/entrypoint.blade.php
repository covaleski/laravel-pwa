@extends('layouts.entrypoint')

@push('assets.preload')
    <link rel="preload" as="style" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush

@push('assets')
    <link rel="icon" type="image/png" href="{{ asset('icons/icon.48x48.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush
