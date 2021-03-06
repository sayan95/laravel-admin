<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role_name' => $this->name, 
            'permissions' => $this->permissions,
            'dates' => [
                'creted_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
