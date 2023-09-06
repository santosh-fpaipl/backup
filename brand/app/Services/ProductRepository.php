<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProductRepository
{
    public static function all()
    {
        $products = Cache::remember('products', 24 * 60 * 60, function () {
            $response = Http::get('http://192.168.1.133:8000/api/internal/products'); 
            return $response->json();
        });

        return $products['data'];
    }

    public static function get($id)
    {
        $productId = 'product' . $id;
        Cache::forget($productId);
        $product = Cache::remember($productId, 24 * 60 * 60, function () use($id) {
            $response = Http::get('http://192.168.1.133:8000/api/internal/products/'.$id); 
            return $response->json();
        });

        return $product['data'];

        
    }
}