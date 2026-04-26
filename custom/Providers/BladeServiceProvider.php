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
        Blade::directive('htmx', function (string $expression) {
            return <<<PHP
                <script <?php echo \\Illuminate\\Support\\Arr::toHtmlAttributes(
                    config('htmx.js'),
                ); ?>></script>
                PHP;
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
    }
}
