<?php

namespace Covaleski\LaravelPwa\Providers;

use Covaleski\LaravelPwa\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
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
        Arr::macro('toHtmlAttributes', function ($values) {
            return collect($values)
                ->whereNotNull()
                ->map(fn ($value, $key) => sprintf('%s="%s"', $key, htmlspecialchars(strval($value))))
                ->values()
                ->join(' ');
        });
        Route::macro('pwa', function ($path, $name, $view) {
            Route::any(
                uri: trim($path, '/') . '/{path?}',
                action: function (
                    Request $request,
                    ?string $path = null
                ) use ($view) {
                    return $request->hasHeader('HX-Request')
                        ? Page::make($path)
                        : view($view, ['path' => $path]);
                },
            )->where('path', '.*')->name($name);
        });
    }
}
