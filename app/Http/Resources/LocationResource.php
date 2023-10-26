<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class LocationResource extends WFJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getFromRequest(true);
    }
}
