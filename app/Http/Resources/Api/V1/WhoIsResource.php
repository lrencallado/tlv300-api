<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhoIsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'domain_information' => [
                'domain_name' => $this['domainName'],
                'registrar_name' => $this['registrarName'],
                'registration_date' => $this['createdDateNormalized'] ?? null,
                'estimated_domain_age' => $this['estimatedDomainAge'],
                'hostnames' => isset($this['nameServers']) ? $this['nameServers']['hostNames'] : null
            ],
            'contact_information' => [
                'registrant_name' => isset($this['registrant']) && isset($this['registrant']['name']) ? $this['registrant']['name'] : null,
                'technical_contact_name' => isset($this['technicalContact']) && isset($this['technicalContact']['name']) ? $this['technicalContact']['name'] : null,
                'administrative_contact_name' => isset($this['administrativeContact']) && isset($this['administrativeContact']['name']) ? $this['administrativeContact']['name'] : null,
                'contact_email' => $this['contactEmail'],
            ],
        ];
    }
}
