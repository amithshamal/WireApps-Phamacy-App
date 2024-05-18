<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tokenInfo = $this->createToken("wireApps-pharmacy-management-system");
        $token = $tokenInfo->plainTextToken;
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'token' => $token,
            'role' => $this->role
        ];
    }
}
