<?php

namespace Covaleski\LaravelPwa\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Path for Blade views.
     */
    protected string $path;

    /**
     * Create the service provider instance.
     */
    public function __construct($app)
    {
        $this->path = dirname(dirname(__DIR__)) . '/resources/views';
        return parent::__construct($app);
    }

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
        Blade::directive('pwaContainer', function (string $expression) {
            return <<<PHP
                <?php echo \Illuminate\Support\Arr::toHtmlAttributes(
                    array_merge_recursive(
                        ['hx-headers' => json_encode(['X-Csrf-Token' => csrf_token()])],
                        config('pwa.attributes.container'),
                        collect({$expression})->all(),
                    ),
                ); ?>
                PHP;
        });
        Blade::directive('pwaLink', function (string $expression) {
            return <<<PHP
                <?php echo \Illuminate\Support\Arr::toHtmlAttributes([
                    'hx-get' => {$expression},
                    'hx-push-url' => 'true',
                ]); ?>
                PHP;
        });
        Blade::directive('pwaOverlay', function (string $expression) {
            return <<<PHP
                <?php echo \Illuminate\Support\Arr::toHtmlAttributes(
                    array_merge_recursive(
                        config('pwa.attributes.overlay'),
                        collect({$expression})->all(),
                    ),
                ); ?>
                PHP;
        });
        Blade::directive('pwaScript', function (string $expression) {
            return <<<PHP
                <?php echo \Illuminate\Support\Arr::toHtmlAttributes(
                    array_merge_recursive(
                        config('pwa.attributes.script'),
                        collect({$expression})->all(),
                    ),
                ); ?>
                PHP;
        });
        Blade::directive('pwaShell', function (string $expression) {
            return <<<PHP
                <?php echo \Illuminate\Support\Arr::toHtmlAttributes(
                    array_merge_recursive(
                        ['hx-get' => \$url],
                        config('pwa.attributes.shell'),
                        collect({$expression})->all(),
                    ),
                ); ?>
                PHP;
        });
    }
}
