<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Example App</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <style>{{ config('pwa.styles') }}</style>
    </head>
    <body @appContainer()>
        <div @appShell()></div>
        <div @appOverlay()></div>
        <script @appScript()></script>
    </body>
</html>
