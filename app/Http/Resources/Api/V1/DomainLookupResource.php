<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DomainLookupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $domainInfo = [
            'domain_name' => $this['domainName'],
            'registrar_name' => $this['registrarName'] ?? null,
            'registration_date' => $this['createdDate'] ?? null,
            'estimated_domain_age' => $this['estimatedDomainAge'] ?? null,
            'hostnames' => isset($this['nameServers']) ? $this['nameServers']['hostNames'] : null
        ];

        $contantInfo = [
            'registrant_name' => isset($this['registrant']) && isset($this['registrant']['name']) ? $this['registrant']['name'] : null,
            'technical_contact_name' => isset($this['technicalContact']) && isset($this['technicalContact']['name']) ? $this['technicalContact']['name'] : null,
            'administrative_contact_name' => isset($this['administrativeContact']) && isset($this['administrativeContact']['name']) ? $this['administrativeContact']['name'] : null,
            'contact_email' => $this['contactEmail'] ?? null,
        ];

        if ($request->type == 'domain') {
            return $domainInfo;
        } else if ($request->type == 'contact') {
            return $contantInfo;
        } else {
            return [
                'domain_information' => $domainInfo,
                'contact_information' => $contantInfo
            ];
        }
    }
}
