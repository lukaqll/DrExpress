<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'doc_number' => $this->doc_number,
            'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'picture' => $this->picture,
            'banner' => $this->banner,
            'status' => $this->status,

            'roles' => $this->roles->pluck('slug'),
            'permissions' => $this->permissions(),
            'picture' => $this->defaultPicture(),
        ];
    }
}
