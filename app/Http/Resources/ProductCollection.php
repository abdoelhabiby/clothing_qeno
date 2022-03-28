<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends JsonResource
{


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            "name" => $this->name,
            "slug" => $this->slug,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'vendor' => $this->vendor ?  $this->vendor->name : null,
            "is_active" => $this->is_active ? 'active' : "deactive",
            "image" => $this->image && File::exists(public_path($this->image)) ? asset($this->image) : pathNoImage(),
        ];
    }
}
