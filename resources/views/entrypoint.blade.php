@extends('layouts.entrypoint')

@push('preload')
    <link rel="preload" as="style" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/main.css') }}"/>
@endpush
