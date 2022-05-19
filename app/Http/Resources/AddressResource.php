<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'id_client' => $this->id_client,
            'id_user' => $this->id_user,
            'type' => $this->type,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'reference' => $this->reference,
            'cep' => $this->cep,
            'deleted' => $this->deleted,
            
            'id_district' => $this->id_district,
            'district_name' => $this->district->name,

            'id_city' => $this->district->id_city,
            'city_name' => $this->district->city->name,

            'id_uf' => $this->district->city->id_uf,
            'uf_name' => $this->district->city->uf->name,

            'is_default' => $this->id == $this->user->id_address
        ];
    }
}
