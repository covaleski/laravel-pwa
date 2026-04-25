<?php

namespace Covaleski\LaravelPwa\Page;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RenderedPage implements Responsable
{
    /**
     * Create the rendered page instance.
     */
    public function __construct(
        /**
         * Rendered page name.
         */
        public string $page,

        /**
         * Rendered content.
         */
        public string $content,

        /**
         * Expected shell name.
         */
        public string $shell,
    ) {
        //
    }

    /**
     * Get a response for the specified request that swaps the shell page.
     */
    public function toPageSwapResponse(Request $request): Response
    {
        return response($this->content, 200, [
            'HX-Retarget' => '.app__page',
            'HX-Trigger' => json_encode([
                'pageswap' => [
                    'page' => $this->page,
                ],
            ]),
        ]);
    }

    /**
     * Get a response for the specified request.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return $this->shouldSwapShell($request->header('HX-Shell-Name'))
            ? $this->toShellSwapResponse($request)
            : $this->toPageSwapResponse($request);
    }

    /**
     * Get a response for the specified request that swaps the app shell.
     */
    public function toShellSwapResponse(Request $request): Response
    {
        return response($this->wrap(), headers: [
            'HX-Retarget' => '.app__shell',
            'HX-Trigger' => json_encode([
                'shellswap' => [
                    'shell' => $this->shell,
                    'page' => $this->page,
                ],
            ]),
        ]);
    }

    /**
     * Get contents wrapped in the page's shell.
     */
    public function wrap(): string
    {
        return view(
            view: $this->prefixShell($this->shell),
            data: ['content' => $this->content],
        )->render();
    }

    /**
     * Prefix a page name with the view name prefix.
     */
    protected function prefixShell(string $shell): string
    {
        return "shell.{$shell}";
    }

    /**
     * Get whether the specified shell should be swapped.
     */
    protected function shouldSwapShell(string $shell): bool
    {
        return trim($shell) !== trim($this->shell);
    }
}
