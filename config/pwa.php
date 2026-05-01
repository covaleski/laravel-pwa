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

        'overlay' => [
            'id' => 'overlay',
            'class' => 'app__overlay',
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

    /*
    |--------------------------------------------------------------------------
    | Critical Styles
    |--------------------------------------------------------------------------
    |
    | This option defines critical CSS styles that can't be lazy loaded and
    | will be directly embedded into the entrypoint view.
    |
    | You'll probably just want to use this option to customize the application
    | overlay element.
    |
    */

    'styles' => <<<CSS
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
        CSS,

];
