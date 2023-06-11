<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourismResource  extends JsonResource
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
            'mobile' => $this->mobile,
            'role' => $this->role,
            'email' => $this->email,
            'description' => $this->description,
            'lat' => $this->lat,
            'long' => $this->long,
            'license' => $this->license,
            'valid' => $this->valid,
        ];
    }
}
