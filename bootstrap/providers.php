<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    Covaleski\LaravelPwa\Providers\PackageServiceProvider::class,
    Covaleski\LaravelPwa\Providers\BladeServiceProvider::class,
    Covaleski\LaravelPwa\Providers\HelperServiceProvider::class,
];
