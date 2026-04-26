<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default HTMX Headers
    |--------------------------------------------------------------------------
    |
    | This option sets the default HTMX header overrides used by the client to
    | fetch page contents and send data to the server.
    |
    | You can also override any attributes in the entrypoint view.
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
            'style' => [
                'background: green',
                'position: fixed',
                'top: 0',
                'left: 0',
                'width: 100vw',
                'height: 100vh',
                'z-index: 9999',
                'transition: opacity 500ms, width 0ms 500ms, height 0ms 500ms',
            ],
        ],

        'shell' => [
            'hx-headers' => '{"HX-Current-Shell": ""}',
            'hx-push-url' => 'true',
            'hx-trigger' => 'load from:window',
            'class' => 'app__shell',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | HTMX Script Attributes
    |--------------------------------------------------------------------------
    |
    | This option defines the attributes of the script tag used to include
    | HTMX's features to the page.
    |
    */

    'script' => [
        'crossorigin' => 'anonymous',
        'hash' => 'sha384-H5SrcfygHmAuTDZphMHqBJLc3FhssKjG7w/CeCpFReSfwBWDTKpkzPP8c+cLsK+V',
        'src' => 'https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js',
        'type' => 'text/javascript',
    ],

];
