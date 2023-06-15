<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       $profile =Facility::where('user_id',$this->id)->first();
        return [
            'id' => $this->id,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'email' => $this->email,
            'profile' => $profile,
            'category' => Category::where('id',$profile->category_id)->first(),
            
        ];
    }
}
