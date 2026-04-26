<?php

namespace Covaleski\LaravelPwa\Providers;

use Covaleski\LaravelPwa\Routing\PageRouter;
use Illuminate\Http\Request;
use Illuminate\Support;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->macroFacades();
        $this->macroSupport();
    }

    /**
     * Add macros to facades.
     */
    protected function macroFacades(): void
    {
        Facades\Request::macro('htmx', function () {
            /** @var Request $this */
            return $this->hasHeader('HX-Request');
        });
        Facades\Route::macro('pwa', function ($directory, $entrypoint, $route_prefix, $uri_prefix, $view_prefix) {
            PageRouter::make(
                directory: $directory,
                entrypoint: $entrypoint,
                route_prefix: $route_prefix,
                uri_prefix: $uri_prefix,
                view_prefix: $view_prefix,
            )->route();
        });
        Facades\Storage::macro('root', function ($path = '') {
            return Facades\Storage::build([
                'driver' => 'local',
                'root' => base_path($path),
            ]);
        });
    }

    /**
     * Add macros to helper classes.
     */
    protected function macroSupport(): void
    {
        Support\Arr::macro('toHtmlAttributes', function ($values) {
            return collect($values)
                ->whereNotNull()
                ->transform(function ($value, $key) {
                    switch ($key) {
                        case 'class':
                            $value = Support\Arr::toCssClasses($value);
                            break;
                        case 'style':
                            $value = Support\Arr::toCssStyles($value);
                            break;
                    }
                    $value = htmlspecialchars(strval($value));
                    return "{$key}=\"{$value}\"";
                })
                ->values()
                ->join(' ');
        });
        Support\Stringable::macro('normalizePath', function () {
            /** @var Illuminate\Support\Stringable $this */
            return $this
                ->replace('\\', '/')
                ->replaceMatches('|(?<=.)/+|', '/')
                ->whenTest('/^.:/', fn ($str) => $str->ucfirst());
        });
    }
}
