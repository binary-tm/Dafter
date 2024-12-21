<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReimbursementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
              
            'id' => $this->id??0,
            'mone_proses' => $this->mone_proses??0,  
            'id_custmer' => $this->id_custmer??0,
            'details' => $this->details??'',
            'created_at' => $this->created_at??'',
            'updated_at' => $this->updated_at??'',
            'id_user' => $this->id_user,
        
        ];
    }
}
