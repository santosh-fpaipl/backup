<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeederPart2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * Clear old data
         */

         DB::table('so_items')->delete();
         DB::table('gdns')->delete();
         DB::table('sale_orders')->delete();


        /**
         * Section 5: Start ---------------------------
         * 
         * NOTE: Each SO belongs to each fabric used in one catelog.
         * and each required color of that fabric for that catelog 
         * will became the SO Item.
         * 
            * Now new sales order will be created for 500 pcs of product
            * which requires following fabrics in respective quantity.
            * 
            * Product A
            * -- Fabric1
            * -- --color a - 140 mtr  
            * -- --color b - 190 mtr  
            * -- --color c - 140 mtr 
            * 
            * Product B
            * -- Fabric1
            * -- --color a - 140 mtr
            * -- --color b - 100 mtr
            * -- Fabric2
            * -- --color a - 80 mtr
            * -- --color b - 60 mtr
         */

            $so_summary = [
                [
                    'stock_id' => 1,
                    'stock_colors' => [1,2,3],
                ],
                [
                    'stock_id' => 1,
                    'stock_colors' => [2,3],
                ], 
                // [
                //     'stock_id' => 2,
                //     'stock_colors' => [4,5],
                // ]  
            ];

            foreach ($so_summary as $so_data) {
                $selectedFabric = \App\Models\Stock::find($so_data['stock_id']);
                $selectedColors = $selectedFabric->stockColors->filter(function($color) use($so_data) {
                return in_array($color->id, $so_data['stock_colors']);
                });
        
                $newSaleOrder = \App\Models\SaleOrder::create([
                    'customer_id' => 1,
                    'stock_id' => $selectedFabric->id,
                    'so_id' => \App\Models\SaleOrder::generateId(),
                    'variation' => 0.05,
                    'rate' => $selectedFabric->sale_price,
                    'payment_terms' => 'test test',
                    'delivery_terms' =>'test test',
                    'quality_terms' => 'test test',
                    'general_terms' => 'test test',
                ]);
        
                foreach ($selectedColors as $selectedColor) {
                
                    $pre_order = 0;
            
                    $newSoItem = \App\Models\SoItem::create([
                        'sale_order_id' => $newSaleOrder->id,
                        'stock_color_id' => $selectedColor->id,
                        'quantity' => $selectedColor->quantity * 0.2,
                    ]);
            
                    if(!$pre_order){
                        /**
                         *  It sum the all the quantity of all the sale items of pending sale orders. if the quantity is greater than than the stock quantity, then set the current sale order as pre order (1) otherwise normal(pre order (1))
                         */
                        $pendingQuantity = \App\Models\SaleOrder::join('so_items', 'sale_orders.id', '=', 'so_items.sale_order_id')
                                        ->where('sale_orders.pending', 1)
                                        ->where('so_items.stock_color_id', $selectedColor->id)
                                        ->sum('so_items.quantity');
            
                        if($pendingQuantity > $newSoItem->stockColor->quantity){
                            $pre_order = 1;
                            $newSaleOrder->update(['pre_order' => $pre_order]);
                        }
                    
                    }
                }
            }


        // ---------------------------------- Section 5: End
    }
}
