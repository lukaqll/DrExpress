<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerCartResource extends JsonResource
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
            'phone' => $this->phone,
            'picture' => $this->picture,
            'doc_number' => $this->doc_number,
            'cro' => $this->cro,

            'picture' => $this->defaultPicture(),
            'banner' => $this->defaultBanner(),

            'cart_items' => CartItemResource::collection($this->cartItems),
            'served' => new ServedDistrictResource($this->districtServed())
        ];
    }
}
