<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTreeResource extends JsonResource
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
            'required_cro' => $this->required_cro,
            'linkable' => $this->linkable,
            'children' =>  $this->linkable ? CategoryTreeResource::collection($this->children) : null,
            'id_parent' =>  $this->parent ? $this->parent->id : null,
            'specs'    =>  !$this->linkable ? SpecResource::collection($this->specs) : null,
        ];
    }
}
