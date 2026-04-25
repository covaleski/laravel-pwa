<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\View\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Storage;

class PageRouter
{
    /**
     * Create a page router instance.
     */
    public static function make(
        string $uri_prefix,
        string $entrypoint,
        string $directory,
        string $view_prefix,
        string $route_prefix,
    ): static {
        return new static(
            directory: $directory,
            entrypoint: $entrypoint,
            routePrefix: $route_prefix,
            uriPrefix: $uri_prefix,
            viewPrefix: $view_prefix,
        );
    }

    /**
     * Create the page router instance.
     */
    final public function __construct(
        protected string $uriPrefix,
        protected string $entrypoint,
        protected string $directory,
        protected string $viewPrefix,
        protected string $routePrefix,
    ) {
        $this->routePrefix = str($this->routePrefix)->trim('.')->toString();
        $this->uriPrefix = str($this->uriPrefix)->trim('/')->toString();
        $this->viewPrefix = str($this->viewPrefix)->trim('.')->toString();
    }

    /**
     * Add the page routes.
     */
    public function route(): void
    {
        foreach ($this->getRoutes() as $route) {
            Facades\Route::any(
                $this->getUriFromRouteName($route),
                $this->getAction(
                    $route,
                    $this->getViewNameFromRouteName($route),
                ),
            )->name($route);
        }
    }

    /**
     * Get the route callback for the specified route and view names.
     */
    protected function getAction(string $route, string $view): Closure
    {
        return function (Request $request) use ($route, $view) {
            return $request->htmx()
                ? Page::make(view($view, $request->route()->parameters()))
                : view($this->entrypoint, ['route' => $route]);
        };
    }

    /**
     * Get all relative file paths in the base directory.
     */
    protected function getFiles(): array
    {
        return Storage::root($this->directory)->files(recursive: true);
    }

    /**
     * Get the page view name for the specified relative file path.
     */
    protected function getRouteNameFromFile(string $file): string
    {
        return str($file)
            ->normalizePath()
            ->after(':')
            ->start('/')
            ->before('/page.blade.php')
            ->ltrim('/')
            ->replace('/', '.')
            ->prepend($this->routePrefix, '.')
            ->rtrim('.')
            ->toString();
    }

    /**
     * Get all views that are eligible to be routed as a page.
     */
    protected function getRoutes(): array
    {
        return collect($this->getFiles())
            ->filter($this->isPage(...))
            ->map($this->getRouteNameFromFile(...))
            ->toArray();
    }

    /**
     * Get the page URI for the specified route name.
     */
    protected function getUriFromRouteName(string $route): string
    {
        return str($route)
            ->after($this->routePrefix)
            ->swap(['.' => '/', '[' => '{', ']' => '}'])
            ->ltrim('/')
            ->prepend($this->uriPrefix, '/')
            ->toString();
    }

    /**
     * Get the page view name for the specified route name.
     */
    protected function getViewNameFromRouteName(string $route): string
    {
        return str($route)
            ->after($this->routePrefix)
            ->ltrim('.')
            ->prepend($this->viewPrefix, '.')
            ->rtrim('.')
            ->append('.page')
            ->ltrim('.')
            ->toString();
    }

    /**
     * Get whether a file is a page view.
     */
    protected function isPage(string $file): bool
    {
        return str(basename($file))->exactly('page.blade.php');
    }
}
