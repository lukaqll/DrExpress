<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id_category' => $this->id_category,
            'name' => $this->name,
            'description' => $this->description,
            'brand' => $this->brand,
            'color' => $this->color,
            'model' => $this->model,
            'price' => $this->price,
            'price_currency' => number_format($this->price, 2, ',', '.'),
            'slug' => $this->slug,
            'guarantee' => $this->guarantee,
            'status' => $this->status,
            'status_text' => $this->statusText(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at, 
            'created_for_humans' => $this->created_at->diffForHumans(),

            'images'          => $this->defaultImages(),
            'principal_image' => $this->principalImage(),
            'specs'           => ProductSpecResource::collection($this->getSpecs()),
            'category_flow'   => $this->getCategoryFlow(),
            'amount'          => $this->getAmount(),
            'category'        => new CategoryResource($this->category)
        ];
    }
}
