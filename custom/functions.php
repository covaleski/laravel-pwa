<?php

use Illuminate\View\ComponentAttributeBag;

if (!function_exists('attributes')) {
    /**
     * Turn the specified array into HTML attributes.
     */
    function attributes(array $attributes): ComponentAttributeBag
    {
        return new ComponentAttributeBag($attributes);
    }
}
