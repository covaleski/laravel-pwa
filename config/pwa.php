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
                // Get the shell element...
                let element = document.querySelector('.app__shell');
                // Set modifier...
                let classList = element?.classList;
                if (classList) for (const className of classList?.values()) {
                    if (className.startsWith('app__shell--')) {
                        classList?.remove(className);
                    }
                }
                if (classList && event.detail.modifier) {
                    classList?.add(`app__shell--${event.detail.modifier}`);
                }
                // Set X-Current-Shell header...
                let json = element?.getAttribute('hx-headers') || '{}';
                let headers = JSON.parse(json);
                headers['HX-Current-Shell'] = event.detail.shell;
                json = JSON.stringify(headers);
                element?.setAttribute('hx-headers', json);
                // Hide overlay...
                let overlay = document.querySelector('.app__overlay');
                overlay?.classList?.add('app__overlay--hidden');
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

        .app__overlay.app__overlay--hidden {
            opacity: 0;
            width: 0;
            height: 0;
        }
        CSS,

];
