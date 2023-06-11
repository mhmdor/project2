<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->name,
            'last_name' => $this->lastName,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'email' => $this->email,
            'gender' => $this->gender,
            'birth' => $this->birth,
            'valid' => $this->valid,
        ];
    }
}
