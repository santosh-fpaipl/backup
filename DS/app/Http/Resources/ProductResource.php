<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OptionResource;
use App\Http\Resources\RangeResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        
        return [
            'id' =>$this->id,
            'name' => $this->name,
            'code' => $this->code,
            'start_price' => $this->start_price,
            'end_price' => $this->end_price,
            'price' => $this->start_price,
            'moq' => $this->moq,
            'hsncode' => $this->hsncode,
            'gstrate' => $this->gstrate,
            'styleid' => '#45957',
            'fabricator_id' => 1,
            'tags' => $this->tags,
            'options' => OptionResource::collection($this->options),
            'ranges' => RangeResource::collection($this->ranges),
        ];
    }
}
