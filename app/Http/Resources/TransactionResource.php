<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'id_user' => $this->id_user??0,
          
            'type' => __(
                'mass.' . $this->type, 
                [], 
                config('app.locale')
            ) ?: 0,
            'amount' => $this->amount??0,
            
            'created_at' => $this->created_at->format('Y-m-d')??'',
              // 'id_supplier' => $this->id_supplier??0,
            // 'id_customer' => $this->id_customer??0,
            'client_data' => $this->supplier ? new CustomerResource($this->supplier) : new CustomerResource($this->customer),
            // 'customer' => $this->customer ? new CustomerResource($this->customer) : [],
            'trans_data' => $this->trans_data?? (object)[],

        ];
    }
}
