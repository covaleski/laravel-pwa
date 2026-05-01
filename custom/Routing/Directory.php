<?php

namespace Covaleski\LaravelPwa\Routing;

class Directory
{
    /**
     * Create the directory instance.
     */
    public function __construct(
        /**
         * Assigned middleware.
         */
        public array $middleware = [],
    ) {
        //
    }

    /**
     * Get a clone of this instance.
     */
    public function clone(): static
    {
        return clone $this;
    }

    /**
     * Merge the specified directory options with the current one.
     */
    public function merge(Directory $options): static
    {
        $result = $this->clone();
        array_push($result->middleware, ...$options->middleware);
        $result->middleware = array_unique($result->middleware);
        return $result;
    }
}
