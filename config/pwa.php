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
            'hx-on:pageswap' => <<<'JS'
                console.log('Handling hx-on:pageswap...');
                JS,
            'hx-on:shellswap' => <<<'JS'
                let element, headers, json, style;
                // Set X-Current-Shell header...
                element = document.querySelector('.app__shell');
                json = element?.getAttribute('hx-headers') || '{}';
                console.log(json);
                headers = JSON.parse(json);
                headers['HX-Current-Shell'] = event.detail.shell || '';
                json = JSON.stringify(headers);
                console.log(json);
                element?.setAttribute('hx-headers', json);
                // Hide overlay...
                element = document.querySelector('.app__overlay');
                style = element?.style;
                style?.setProperty('height', '0');
                style?.setProperty('opacity', '0');
                style?.setProperty('width', '0');
                JS,
            'class' => 'app',
        ],

        'overlay' => [
            'class' => 'app__overlay',
        ],

        'shell' => [
            'hx-headers' => '{"HX-Current-Shell": ""}',
            'hx-push-url' => 'true',
            'hx-trigger' => 'load from:window',
            'class' => 'app__shell',
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
        CSS,

];
