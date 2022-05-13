<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OperatorResource extends JsonResource
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

            'roles' => $this->roles,
            'id_roles' => $this->roles->pluck('id'),
            'permissions' => $this->permissions(),
            'status_text' => $this->statusText(),
        ];
    }
}
