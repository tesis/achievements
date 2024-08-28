<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'watched_count' => $this->resource['watched_count'],
            'comments_count' => $this->resource['comments_count'],
            'unlocked_achievements' => $this->resource['unlocked_achievements'],
            'next_available_achievements' => $this->resource['next_available_achievements'],
            'current_badge' => $this->resource['current_badge'],
            'next_badge' => $this->resource['next_badge'],
            'remaining_to_unlock_next_badge' => $this->resource['remaining_to_unlock_next_badge'],
        ];
    }
}
