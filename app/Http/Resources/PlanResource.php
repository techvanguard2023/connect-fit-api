<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PlanResource extends JsonResource
{
    public function toArray($request): array
    {
        $slug = $this->slug ?? Str::slug($this->name); // use 'slug' se existir

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'price'       => (float) $this->price,
            'period'      => $this->period === 'monthly' ? 'mês' : $this->period,
            'description' => $this->description,
            'icon'        => config("plans.icons.$slug") ?? 'Check',
            'popular'     => (bool) $this->popular,
            'features'    => $this->whenLoaded('features', fn () =>
                $this->features->pluck('name')->toArray()
            ),
        ];
    }
}
