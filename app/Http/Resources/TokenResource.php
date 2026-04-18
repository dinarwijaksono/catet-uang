<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "api_token" => $this->token,
            "expired_at" => $this->expired_at->format('H:i, j F Y'),
            "created_at" => $this->created_at->format('H:i, j F Y'),
            "updated_at" => $this->updated_at->format('H:i, j F Y')
        ];
    }
}
