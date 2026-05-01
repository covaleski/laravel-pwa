@extends('layouts.entrypoint')

@push('assets.preload')
    <link rel="preload" as="style" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush

@push('assets')
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush
