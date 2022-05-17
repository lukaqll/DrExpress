<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'picture' => $this->picture,
            'doc_number' => $this->doc_number,
            'birthdate' => $this->birthdate,
            'cro' => $this->cro,
            'is_delivery' => $this->is_delivery,
            'is_physical' => $this->is_physical,

            'id_city' => $this->id_city,
            'id_uf' => $this->city && $this->city->id_uf ? $this->city->id_uf : null,

            'roles' => $this->roles,
            'id_roles' => $this->roles->pluck('id'),
            'permissions' => $this->permissions(),
            'status_text' => $this->statusText(),
        ];
    }
}
