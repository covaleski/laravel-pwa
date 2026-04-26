<?php

namespace Covaleski\LaravelPwa\Providers;

use Illuminate\Support\Arr;
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
        Blade::directive('pwaScript', function (string $expression) {
            return $this->makeAttributeMergeDirective(
                "config('pwa.attributes.script')",
                $expression,
            );
        });
        Blade::directive('shell', function (string $expression) {
            /** @var \Illuminate\View\Compilers\BladeCompiler $this */
            $this->footer[] = '<?php echo $__env->stopFragment(); ?>';
            return <<<PHP
                <?php \$__env->startFragment('shell'); ?>
                <?php echo strval({$expression}); ?>
                <?php echo \$__env->stopFragment(); ?>
                <?php \$__env->startFragment('page'); ?>
                PHP;
        }, true);
        Blade::directive('pwaContainer', function (string $expression) {
            return $this->makeAttributeMergeDirective(
                "['hx-headers' => json_encode(['X-Csrf-Token' => csrf_token()])]",
                "config('pwa.attributes.container')",
                $expression,
            );
        });
        Blade::directive('pwaShell', function (string $expression) {
            return $this->makeAttributeMergeDirective(
                "['hx-get' => \$url]",
                "config('pwa.attributes.shell')",
                $expression,
            );
        });
        Blade::directive('pwaOverlay', function (string $expression) {
            return $this->makeAttributeMergeDirective(
                "config('pwa.attributes.overlay')",
                $expression,
            );
        });
    }

    /**
     * Create a directive to merge HTML attributes from array input.
     */
    protected function makeAttributeMergeDirective(string ...$expressions)
    {
        return sprintf(
            '<?php echo %s::toHtmlAttributes(array_merge_recursive(%s)); ?>',
            Arr::class,
            collect($expressions)
                ->transform(fn ($v) => $v ?: '[]')
                ->map(fn ($e) => "(array) {$e},")
                ->join(' '),
        );
    }
}
