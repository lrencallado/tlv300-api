<?php

namespace App\Services\Api\V1;

use App\Enums\Api\V1\ApiResponseCode;
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
        $response = Http::whoisApi()->get('/whoisserver/WhoisService', [
            'domainName' => $domainName,
            'outputFormat' => 'JSON',
        ]);

        if ($response->successful()) {
            $result = $this->handleResponse($response->json());
        }

        if ($response->clientError()) {
            $result = $this->handleResponse(['status' => ApiResponseCode::SERVER_ERROR]);
        }

        if ($response->serverError()) {
            $result = $this->handleResponse(['status' => ApiResponseCode::SERVER_ERROR]);
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
