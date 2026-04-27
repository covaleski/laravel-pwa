<?php

namespace Covaleski\LaravelPwa\View;

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
         * View name.
         */
        public string $view,

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
                    'page' => $this->view,
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
        return $this->shouldSwapShell($request->header('HX-Current-Shell', ''))
            ? $this->toShellSwapResponse($request)
            : $this->toPageSwapResponse($request);
    }

    /**
     * Get a response for the specified request that swaps the app shell.
     */
    public function toShellSwapResponse(Request $request): Response
    {
        $content = $this->wrap();
        return response($content, headers: [
            'HX-Retarget' => '.app__shell',
            'HX-Trigger' => json_encode([
                'shellswap' => [
                    'shell' => $this->shell,
                    'page' => $this->view,
                ],
            ]),
        ]);
    }

    /**
     * Get contents wrapped in the page's shell.
     */
    public function wrap(): string
    {
        /** @var Illuminate\View\View */
        $view = view($this->shell, ['content' => $this->content]);
        return $view->fragment('content');
    }

    /**
     * Get whether the specified shell should be swapped.
     */
    protected function shouldSwapShell(string $shell): bool
    {
        return trim($shell) !== trim($this->shell);
    }
}
