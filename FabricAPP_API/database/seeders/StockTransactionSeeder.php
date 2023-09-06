<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\StockTransaction;

class StockTransactionSeeder extends Seeder
{
    public static function transactionUpdate($transactionType, $bundle, $quantity, $stock_item){

        $latestStockTransaction = StockTransaction::where('stock_item_id', $stock_item->id)->latest('id')->first();

        if(empty($latestStockTransaction)){
            $opening = 0.00;
            $closing = $quantity;
            $transactionId = $bundle->grn_id;
        } else{
            $opening = $latestStockTransaction->closing;
            if($transactionType == 'App\Models\Gdn'){
                $transactionId = $bundle->gdn_id;
                $closing = $latestStockTransaction->closing - $quantity;
            } else if($transactionType == 'App\Models\Grn') {
                $transactionId = $bundle->grn_id;
                $closing = $latestStockTransaction->closing + $quantity;
            } else {
                // do nothing
            }
        }
        StockTransaction::create([
            'transactionable_type' => $transactionType,
            'transactionable_id' => $transactionId,
            'stock_item_id' => $stock_item->id,
            'opening' => $opening,
            'quantity'=> $quantity,
            'closing' => $closing,
        ]);
    }
}
