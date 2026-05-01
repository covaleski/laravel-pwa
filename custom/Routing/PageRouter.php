<?php

namespace Covaleski\LaravelPwa\Routing;

use Closure;
use Covaleski\LaravelPwa\View\Page;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PageRouter
{
    /**
     * Filesystem instance.
     */
    protected Filesystem $disk;

    /**
     * Manifest URI.
     */
    protected string $manifest;

    /**
     * Parent options.
     */
    protected Directory $parentOptions;

    /**
     * Parent shell view name.
     */
    protected string $parentShell;

    /**
     * Create the page router instance.
     */
    final public function __construct(
        protected string $entrypoint,
        protected string $route,
        protected string $uri,
        protected string $views,
    ) {
        $this->disk = $this->makeDisk();
    }

    /**
     * Find and route pages.
     */
    public function route(): void
    {
        if (!isset($this->manifest)) {
            $this->manifest = $this->routeManifest();
        }
        $shell = $this->resolveShell();
        $options = $this->resolveOptions();
        Route::any($this->uri, $this->getCallback($shell))
            ->middleware($options->middleware)
            ->name($this->route);
        foreach ($this->disk->directories() as $directory) {
            $this->routeDirectory($directory, $shell, $options);
        }
    }

    /**
     * Set the manifest URI.
     */
    public function withManifest(string $manifest): static
    {
        $this->manifest = $manifest;
        return $this;
    }

    /**
     * Set the parent options.
     */
    public function withParentOptions(Directory $options): static
    {
        $this->parentOptions = $options;
        return $this;
    }

    /**
     * Set the parent shell view name.
     */
    public function withParentShell(string $view): static
    {
        $this->parentShell = $view;
        return $this;
    }

    /**
     * Get the callback for the current page.
     */
    protected function getCallback(string $shell): Closure
    {
        $entrypoint = $this->entrypoint;
        $manifest = $this->manifest;
        $view = $this->makeViewName();
        return function (Request $request) use (
            $entrypoint,
            $manifest,
            $shell,
            $view,
        ) {
            if ($request->htmx()) {
                return Page::make($view, $shell);
            } else {
                return view($entrypoint, ['manifest' => route($manifest)]);
            }
        };
    }

    /**
     * Run the manifest script in the current directory and return its result.
     */
    protected function getManifest(): array
    {
        return require $this->disk->path('manifest.php');
    }

    /**
     * Check whether a manifest script exists in the current directory.
     */
    protected function hasManifest(): bool
    {
        return $this->disk->exists('manifest.php');
    }

    /**
     * Join two dot-separated paths.
     */
    protected function joinPaths(string $a, string $b, string $glue): string
    {
        $a = trim($a, "/. \n\r\t\v\0{$glue}");
        $b = trim($b, "/. \n\r\t\v\0{$glue}");
        return $a . $glue . $b;
    }

    /**
     * Create a filesystem instance for the current page directory.
     */
    protected function makeDisk(): Filesystem
    {
        $view = view($this->makeViewName());
        assert($view instanceof \Illuminate\View\View);
        return Storage::build([
            'driver' => 'local',
            'root' => dirname($view->getPath()),
        ]);
    }

    /**
     * Create the shell view name for the current views path.
     */
    protected function makeShellName(): string
    {
        return "{$this->views}.shell";
    }

    /**
     * Create the page view name for the current views path.
     */
    protected function makeViewName(): string
    {
        return "{$this->views}.page";
    }

    /**
     * Checks whether the current directory overrides the current options.
     */
    protected function overridesOptions(): bool
    {
        return $this->disk->exists('options.php');
    }

    /**
     * Checks whether the current directory overrides the current shell.
     */
    protected function overridesShell(): bool
    {
        return view()->exists($this->makeShellName());
    }

    /**
     * Load option overrides from the current directory.
     */
    protected function requireOptions(): Directory
    {
        return require $this->disk->path('options.php');
    }

    /**
     * Get the final directory options for the current page.
     */
    protected function resolveOptions(): Directory
    {
        $options = isset($this->parentOptions)
            ? $this->parentOptions->clone()
            : new Directory();
        return $this->overridesOptions()
            ? $options->merge($this->requireOptions())
            : $options;
    }

    /**
     * Get the final shell name for the current page.
     */
    protected function resolveShell(): string
    {
        if ($this->overridesShell()) {
            return $this->makeShellName();
        } elseif (isset($this->parentShell)) {
            return $this->parentShell;
        } else {
            throw new RuntimeException('Missing parent shell view');
        }
    }

    /**
     * Add routes for the current directory recursively.
     */
    protected function routeDirectory(string $directory, string $shell, Directory $options): void
    {
        $router = new static(
            entrypoint: $this->entrypoint,
            route: $this->joinPaths($this->route, $directory, '.'),
            uri: $this->joinPaths($this->uri, $directory, '/'),
            views: $this->joinPaths($this->views, $directory, '.'),
        );
        $router
            ->withManifest($this->manifest)
            ->withParentOptions($options)
            ->withParentShell($shell)
            ->route();
    }

    /**
     * Add a route for the current directory manifest.
     */
    protected function routeManifest(): string
    {
        if (!$this->hasManifest()) {
            throw new RuntimeException('Missing manifest script');
        }
        $data = $this->getManifest();
        $route = $this->joinPaths($this->route, 'manifest', '.');
        $uri = $this->joinPaths($this->uri, 'app.webmanifest', '/');
        Route::get($uri, function () use ($data) {
            return response()->json($data, 200, [
                'Content-Type' => 'application/manifest+json',
            ]);
        })->name($route);
        return $route;
    }
}
