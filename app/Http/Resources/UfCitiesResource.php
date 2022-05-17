<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UfCitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'initials' => $this->initials,
            'cities' => CityResource::collection($this->cities),
        ];
    }
}
