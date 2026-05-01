<?php

return [
    'short_name' => config('app.name'),
    'name' => config('app.name'),
    'icons' => [
        [
            'src' => asset('icons/icon.512x512.png'),
            'sizes' => '512x512',
            'type' => 'image/png',
            'purpose' => 'any',
        ],
    ],
    'start_url' => '.',
    'display' => 'standalone',
    'theme_color' => 'black',
    'background_color' => 'white',
];
