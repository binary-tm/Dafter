<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class customerResorse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
              
            'id' => $this->id,
            'name' => $this->name,  
            'date_' => $this->date_,
            'address' => $this->address,
            'phone' => $this->phone,
            'id_user' => $this->id_user,
           
           

          
        ];
    }
}
