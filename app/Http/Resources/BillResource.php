<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
         return [
        'id' => $this->id,
        'bill_name' => $this->bill_name,
        'description' => $this->description,
        'status'=>$this->status,
        'photo' => $this->getFirstMedia('preview'),
    ];
    }
}
