<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemSpecResource extends JsonResource
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
            'id_cart_item' => $this->id_cart_item,
            'id_spec' => $this->id_spec,
            'spec' => new SpecResource($this->spec),
            'data' => $this->data,
        ];
    }
}
