<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('whoisApi', function () {
            return Http::baseUrl(config('whois.base_url'))
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->withToken(config('whois.api_key'));
        });
    }
}
