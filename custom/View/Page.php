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
    public static function make(View $view): static
    {
        return new static($view);
    }

    /**
     * Create the page instance.
     */
    final public function __construct(
        /**
         * View
         */
        protected View $view,
    ){
        //
    }

    /**
     * Get the page's expected shell name.
     */
    public function render(): RenderedPage
    {
        return new RenderedPage(
            view: $this->view->name(),
            content: $this->view->fragment('content'),
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
}
