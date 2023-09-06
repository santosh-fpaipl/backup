<?php
namespace App\Http\Providers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Providers\Provider;
use App\Models\Stock;
use App\Http\Resources\StockResource;
use App\Http\Resources\StockByProduct;

class StockProvider extends Provider
{
    public $response = '';
    public $message = '';

    /**
    * Display a listing of the resource.
    */

    public function index()
    {
        $stocks = Stock::select('product_id', DB::raw('SUM(quantity) as quantity'))->groupBy('product_id')->where('active', 1)->get();
        return StockResource::collection($stocks);
    }



    public function stockByProduct(Request $request)
    {
        $stocks = Stock::where('product_id', $request->product_id)->get();
        return StockByProduct::collection($stocks);
    }

   
    
    
}