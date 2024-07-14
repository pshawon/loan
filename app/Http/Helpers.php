<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('is_active_route')) {
    function is_active_route($routeName)
    {
        return Route::currentRouteName() === $routeName ? 'text-white font-bold' : 'text-gray-300';
    }
}

if (! function_exists('are_active_routes')) {
    function are_active_routes(array $routeNames)
    {
        return in_array(Route::currentRouteName(), $routeNames) ? 'true' : 'false';
    }
}
