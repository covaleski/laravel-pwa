<?php

namespace Covaleski\LaravelPwa\View;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Page implements Responsable
{
    /**
     * Create a page instance.
     */
    public static function make(string $view, string $shell): static
    {
        return new static($view, $shell);
    }

    /**
     * Create the page instance.
     */
    final public function __construct(
        /**
         * View name.
         */
        protected string $view,

        /**
         * Shell name.
         */
        protected string $shell,
    ){
        //
    }

    /**
     * Get a response for the specified request.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return $this->shouldSwapShell($request->header('HX-Current-Shell', ''))
            ? $this->toShellSwapResponse($request)
            : $this->toPageSwapResponse($request);
    }

    /**
     * Get whether the specified shell should be swapped.
     */
    protected function shouldSwapShell(string $shell): bool
    {
        return trim($shell) !== trim($this->shell);
    }

    /**
     * Get a response for the specified request that swaps the shell page.
     */
    protected function toPageSwapResponse(Request $request): Response
    {
        return response(view($this->view), 200, [
            'HX-Retarget' => $request->header('HX-Page-Target', '#page'),
            'HX-Reswap' => 'innerHTML',
        ]);
    }

    /**
     * Get a response for the specified request that swaps the app shell.
     */
    protected function toShellSwapResponse(Request $request): Response
    {
        return response(view($this->shell, ['page' => $this->view, 'shell' => $this->shell]), 200, [
            'HX-Retarget' => $request->header('HX-Shell-Target', '#shell'),
            'HX-Reswap' => 'outerHTML',
        ]);
    }
}
