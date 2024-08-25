<?php

namespace App\Services\Api\V1;

use App\Enums\Api\V1\ApiResponseCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WhoIsService
{
    /**
     * Get domain and contact information
     *
     * @param string $domainName
     * @return array
     */
    public function get(string $domainName): array
    {
        // Define the cache key using the domain name
        $cacheKey = "whois_data_{$domainName}";

        // Check if the data is already cached
        $result = Cache::get($cacheKey);

        if (!$result) {
            $response = Http::whoisApi()->get('/whoisserver/WhoisService', [
                'domainName' => $domainName,
                'outputFormat' => 'JSON',
            ]);

            if ($response->successful()) {
                $result = $this->handleResponse($response->json());

                if (! isset($result['ErrorMessage'])) {
                    // Store the result in cache for 24 hours
                    Cache::put($cacheKey, $result, now()->addHours(24));
                }
            }

            if ($response->clientError() || $response->serverError()) {
                $result = $this->handleResponse(['status' => ApiResponseCode::SERVER_ERROR]);
            }
        }

        return $result;
    }

    private function handleResponse(array $data): array
    {
        if (isset($data['ErrorMessage']) && $data['ErrorMessage']['errorCode'] == 'WHOIS_01') {
            return [
                'message' => __('whois.invalid_domain_name'),
                'error' => ApiResponseCode::BAD_REQUEST,
            ];
        }

        if (isset($data['status']) && $data['status'] == ApiResponseCode::SERVER_ERROR->value) {
            return [
                'message' => __('whois.internal_server_error'),
                'error' => ApiResponseCode::SERVER_ERROR,
            ];
        }

        if (isset($data['WhoisRecord'])) {
            return $data['WhoisRecord'];
        }
    }
}
