<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'release_year'   => $this->release_year,
            'price'          => (float) $this->price,
            'rating'         => (float) $this->rating,
            'is_multiplayer' => (bool) $this->is_multiplayer,
            'developer'      => [
                'id'   => $this->developer_id,
                'name' => $this->whenLoaded('developer', fn () => $this->developer->name),   // только если связь загружена
            ],
            'created_at'     => $this->created_at?->toIso8601String(),
        ];
    }
}
