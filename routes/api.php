<?php

use App\Http\Controllers\Api\V1\WhoIsController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::controller(WhoIsController::class)->prefix('whois')->group(function () {
        Route::get('/', 'whois');
    });
});
