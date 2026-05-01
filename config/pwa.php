<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Entrypoint View Element Attributes
    |--------------------------------------------------------------------------
    |
    | This option defines the default attributes for the main elements that
    | compose the application entrypoint view.
    |
    | You can also override any attributes by passing an array of to the
    | `@pwaContainer`, `@pwaShell`, `@pwaOverlay` and `@pwaScript` directives
    | when creating your custom entrypoint view.
    |
    */

    'attributes' => [

        'container' => [
            'hx-headers' => '{"HX-Shell-Target": "#shell", "HX-Page-Target": "#page"}',
            'id' => 'app',
            'class' => 'app',
        ],

        'shell' => [
            'hx-get' => '',
            'hx-headers' => '{"HX-Current-Shell": ""}',
            'hx-push-url' => 'true',
            'hx-swap' => 'outerHTML',
            'hx-trigger' => 'load from:window',
            'id' => 'shell',
            'class' => 'app__not-a-shell',
        ],

        'script' => [
            'crossorigin' => 'anonymous',
            'hash' => 'sha384-H5SrcfygHmAuTDZphMHqBJLc3FhssKjG7w/CeCpFReSfwBWDTKpkzPP8c+cLsK+V',
            'src' => 'https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js',
            'type' => 'text/javascript',
            'defer' => 'true',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Page Router Parameters
    |--------------------------------------------------------------------------
    |
    | This option defines the default parameters when creating a page router
    | instance from the `Route::pwa(...)` method.
    |
    */

    'router' => [
        'route' => 'pwa',
        'uri' => '/app',
        'views' => 'pwa',
    ],

];
