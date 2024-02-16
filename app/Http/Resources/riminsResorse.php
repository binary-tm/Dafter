<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class riminsResorse extends JsonResource
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
            'mone_proses' => $this->mone_proses,  
            'id_custmer' => $this->id_custmer,
            'detels' => $this->detels,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_user' => $this->id_user,
            'D' => $this->d??'',
            'M' => $this->m??'',
            'Y' => $this->y??'',
            

          
        ];
    }
}
