<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WhoisRequest;
use App\Http\Resources\Api\V1\WhoIsResource;
use App\Services\Api\V1\WhoIsService;
use App\Traits\Api\V1\ApiResponses;
use Illuminate\Http\Request;

class WhoIsController extends Controller
{
    use ApiResponses;

    public function whois(WhoisRequest $request, WhoIsService $whoIsService)
    {
        $response = $whoIsService->get($request->domain_name);

        if (isset($response['error'])) {
            return $this->error($response['message'], [], $response['error']);
        }

        return $this->resource(new WhoIsResource($response));
    }
}
