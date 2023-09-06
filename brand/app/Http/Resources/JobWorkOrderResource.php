<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductOptionResource;
use App\Http\Resources\ProductRangeResource;
use App\Services\ProductRepository;
use Carbon\Carbon;

class JobWorkOrderResource extends JsonResource
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
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $product['name'],
            "tags" =>  $product['tags'],
            'quantity' => $this->quantity,
            'message' => $this->message,
            'created_at' => $this->created_at->format('Y-m-d'),
            'expected_at' => $this->expected_at,
            'fabricator_id' => $this->fabricator_id,
            'jwoi' => $this->jwoi,
            'status' => $this->status,
            'colors' => ProductOptionResource::collection($product['options']),
            'sizes' => ProductRangeResource::collection($product['ranges']),
            'quantities' => json_decode($this->quantities),
            'status' => $this->status,
        ];
    }
}
