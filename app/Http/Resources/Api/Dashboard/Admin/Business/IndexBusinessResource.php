<?php

namespace App\Http\Resources\Api\Dashboard\Admin\Business;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexBusinessResource extends JsonResource
{
    public static function collection($resource): array
    {
        return [
            'businesses' => parent::collection($resource),
            'links' => [
                'current' => $resource->url($resource->currentPage()),
                'first' => $resource->url(1),
                'last' => $resource->url($resource->lastPage()),
            ],

            'meta' => [
                'total' => $resource->total(),
                'per_page' => $resource->perPage(),
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
            ]
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ?? '',
            'logo' => $this->logo,
            'is_active' => $this->is_active,
        ];
    }
}
