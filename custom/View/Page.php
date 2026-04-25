<?php

namespace Covaleski\LaravelPwa\View;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class Page implements Responsable
{
    /**
     * Create a page instance.
     */
    public static function make(?string $path): static
    {
        return new static($path);
    }

    /**
     * Page name.
     */
    protected string $name;

    /**
     * View.
     */
    protected View $view;

    /**
     * Create the page instance.
     */
    final public function __construct(
        /**
         * View.
         */
        protected ?string $path,
    ) {
        $this->name = $this->makeName($path);
        $this->view = $this->makeView($this->name);
    }

    /**
     * Get the page's expected shell name.
     */
    public function render(): RenderedPage
    {
        return new RenderedPage(
            page: $this->name,
            content: $this->view->fragment('page'),
            shell: trim($this->view->fragment('shell')),
        );
    }

    /**
     * Get a response for the specified request.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return $this->render()->toResponse($request);
    }

    /**
     * Get the default page name.
     */
    protected function getDefaultPageName(): string
    {
        return 'home';
    }

    /**
     * Get the page name for the specified page path.
     */
    protected function makeName(?string $path): string
    {
        return str($path ?? '')
            ->trim('/')
            ->replace('/', '.')
            ->whenEmpty(fn () => str($this->getDefaultPageName()))
            ->toString();
    }

    /**
     * Create the view for the specified page path.
     */
    protected function makeView(string $page): View
    {
        return view($this->prefixPage($page));
    }

    /**
     * Prefix a page name with the view name prefix.
     */
    protected function prefixPage(string $page): string
    {
        return "page.{$page}";
    }
}
