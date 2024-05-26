<?php

namespace App\Http\Resources\Api\Dashboard\SuperAdmin\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'avatar' => $this->avatar ?? null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s') ?? null,
        ];
    }
}
