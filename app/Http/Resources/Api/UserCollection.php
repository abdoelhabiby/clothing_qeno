<?php

namespace App\Http\Resources\Api;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends JsonResource
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
            "email" => $this->email,
            "image" => $this->image && File::exists(public_path($this->image)) ? asset($this->image) : pathNoImage(),
        ];


    }
}
