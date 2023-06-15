<?php

namespace App\Http\Resources;

use App\Models\tourism;
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
            'mobile' => $this->mobile,
            'role' => $this->role,
            'email' => $this->email,
            'valid' => $this->valid,
            'profile' => tourism::where('user_id',$this->id)->first(),

        ];
    }
}
