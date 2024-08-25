<?php

use App\Http\Controllers\Api\V1\DomainLookupController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Bypassing authorization temporarily
    Route::withoutMiddleware('auth:sanctum')->group(function () {
        Route::controller(DomainLookupController::class)->prefix('domain')->group(function () {
            Route::get('/', 'lookup');
        });
    });
});
