<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartSellerResource extends JsonResource
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
            'status' => $this->status,
            'items'  => CartItemResource::collection($this->items),
            'price' => $this->getPrice(),
            'freight' => $this->getFreight(),
            'total_price' => $this->getTotalPice(),
            
            'sellers'    => SellerCartResource::collection($this->sellers),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
