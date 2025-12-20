<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "original_name" => $this->original_name,
            "file_name" => $this->file_name,
            "is_generate" => $this->is_generate,
            "message" => $this->message,
            'created_at' => $this->created_at->format('H:i, j F Y'),
            'updated_at' => $this->updated_at->format('H:i, j F Y')
        ];
    }
}
