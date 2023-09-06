<?php

namespace App\Http\Providers;
use Illuminate\Support\Facades\Cache;
use App\Http\Providers\Provider;
use App\Models\User;
use App\Models\Supplier;
use App\Http\Resources\SupplierResource;

class SupplierProvider extends Provider
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Cache::forget('suppliers');
        $suppliers = Cache::remember('suppliers', 24 * 60 * 60, function () {
            return Supplier::with('user')->get();
        });
       
        return SupplierResource::collection($suppliers);
    }
}
