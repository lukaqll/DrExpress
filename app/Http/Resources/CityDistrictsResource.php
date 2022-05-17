<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityDistrictsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function CityDistrictsResource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ibge_code' => $this->ibge_code,
            'cep' => $this->cep,
            'uf' => $this->uf,
            'districts' => DistrictResource::collection($this->districts)
        ];
    }
}
