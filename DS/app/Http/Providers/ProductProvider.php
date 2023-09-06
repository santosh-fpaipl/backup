<?php

namespace App\Http\Providers;
use Illuminate\Support\Facades\Cache;
use App\Http\Providers\Provider;
use App\Models\Product;
use App\Models\Option;
use App\Models\Range;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductProvider extends provider
{
    /**
    * Get All Products
    */

    public function index()
    {
        $products = Product::with('options')->with('ranges')->get();
        return ProductResource::collection($products);
    }

    public function show(Request $request)
    {
        $product = Product::find($request->product);
        return new ProductResource($product);
    }
    
}
