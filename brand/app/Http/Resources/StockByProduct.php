<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\ProductRepository;
use App\Http\Resources\productResource;
use App\Http\Resources\ProductOptionResource;
use App\Http\Resources\ProductRangeResource;

class StockByProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        $product = ProductRepository::get($this->product_id);

        $product_option = '';
        foreach($product['options'] as $option){
            if($option['id'] == $this->product_option_id){
                $product_option = $option;
                break;
            }
        }

        $product_range = '';
        foreach($product['ranges'] as $range){
            if($range['id'] == $this->product_range_id){
                $product_range = $range;
                break;
            }
        }
       
        return [
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'product' => new productResource($product),
            'product_option' => new ProductOptionResource($product_option),
            'product_range' => new ProductRangeResource($product_range),
        ];
    }
}
