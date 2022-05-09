<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends JsonResource
{


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // 'posts' => PostResource::collection($this->whenLoaded('posts')),

        return [
            "name" => $this->name,
            "slug" => $this->slug,
            "is_active" => $this->is_active ? 'active' : "deactive",
            "image" => $this->image && File::exists(public_path($this->image)) ? asset($this->image) : pathNoImage(),
            'created_at' => $this->created_at?->format('d-m-Y'),
            "products" => ProductCollection::collection($this->whenLoaded('products')),

        ];
    }
}
