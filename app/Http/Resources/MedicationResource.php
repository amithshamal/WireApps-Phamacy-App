<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'medication_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
        ];
    }
}
