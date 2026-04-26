<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::pwa(
    uri_prefix: '/app',
    entrypoint: 'entrypoint',
    directory: 'resources/views/pages',
    route_prefix: 'page',
    view_prefix: 'pages',
);
