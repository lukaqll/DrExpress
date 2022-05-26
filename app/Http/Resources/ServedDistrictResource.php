<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServedDistrictResource extends JsonResource
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
            'id'          => $this->id,
            'id_district' => $this->id_district,
            'freight'    => $this->freight,
            'min_delivery_time'    => $this->min_delivery_time,
            'max_delivery_time'    => $this->max_delivery_time,
            'time_type' => $this->time_type,
            'time_type_text' => $this->timeTypeText(),

            'district'  => $this->district,
            'city_name' => $this->district->city->name,
            'uf_name'   => $this->district->city->uf->name,
        ];
    }
}
