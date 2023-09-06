<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\StockTransactionSeeder;
use Illuminate\Support\Facades\DB;

class StockSeederPart3 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Section 6: Start -----------------------------
         * 
         * At this stage we have SalesOrder, now we create GDN.
         * This process involves selection of relevant bundle length
         * which may be either Complete Bundle Selection or Partial Bundle selection
         * 
         * This step is handled via view from web.php file
         * 
         * At the end of this step we have all gdn's created for that SaleOrder
         * 
        */
        //------------------------------------ Section 6: End


         /**
         * Section 7: Start -----------------------------
         * 
         * Now after creating GDN we collectivelly and selectivily add them to Sale
         * 
        */

            // User can choose any sale order whoose GDN he wants to 
            // be added to sale bill
            $pendingSaleOrders = \App\Models\SaleOrder::with('soItems')->where('pending', 1)->get();

            // Now we have only those sale orders that have gdn's prepared against them
            $saleOrdersWithGdn = $pendingSaleOrders->filter(function($pendingSaleOrder) {
                return $pendingSaleOrder->gdnCreatedAllSoItems();
            });
            
            if(!empty($saleOrdersWithGdn)){
                // We selected fist and make it complete.
                $saleOrder = $saleOrdersWithGdn->first();
                $saleOrder->update(['pending' => 0]);

                // Also make its respective gdn's live
                foreach($saleOrder->soItems as $soItem){

                    $soItem->gdn->update(['status' => 'live']);

                    // Extracting bundles those are 100% used in respective gdn
                    $singleUsebundles = $soItem->gdn->bundles->filter(function ($bundle) {
                        return $bundle->singleuse === 1;
                    });

                    foreach($singleUsebundles as $singleUsebundle){
                        self::doSomething($singleUsebundle, $singleUsebundle->quantity);
                    }

                    // Extracting bundles those are partially used in respective gdn
                    // $bundleUsage = $soItem->gdn->bundleUsage;
                    // If it has 
                    if($soItem->gdn->hasPartiallyUsedBundle()){
                        foreach($soItem->gdn->bundleUsages as $bundleUsage){
                            self::doSomething($bundleUsage->bundle, $bundleUsage->used);
                        }
                        
                    }
                }
            }
            
        //------------------------------------ Section 7: End


         /**
         * Section 8: Start ---------------------------
         * 
         * Create sale and sale items from selecting gdn's
         * One Sale can contains multiple sale orders.
         */

            $sale = [
                'customer_id' => 1,
                'invoice_no' =>'MC/S0823/'.time(),
                'invoice_date' =>date('Y-m-d', time()),
            ];
            
            $allGdns = [];
            $saleItems = array();
            $subtotal = 0;
            $tax = 0;
            $total = 0;
            // Get all completed sale orders and regarding which we did not created sale.
            $completedSaleOrders = \App\Models\SaleOrder::with('soItems')->where('pending', 0)->whereNull('sale_id')->get();
            
            foreach($completedSaleOrders as $completedSaleOrder){
                foreach($completedSaleOrder->soItems as $soItem){
                    array_push($allGdns, $soItem->gdn->id);
                }
            }
            
            $sale = \App\Models\Sale::create($sale);

            foreach($allGdns as $singleGdn){
                $gdn = \App\Models\Gdn::findOrFail($singleGdn);
                $sale_price = $gdn->stockColor->stock->sale_price;

                $arr = array(
                    'sale_id' => $sale->id,
                    'gdn_id' => $gdn->id,
                    'quantity' => $gdn->quantity,
                    'rate' => $sale_price, // sale price $gdn->stockColor->stock->sale_price
                    'total' => $gdn->quantity * $sale_price,
                    'tax' =>$gdn->quantity * $sale_price * 0.05,
                    'amount' => $gdn->quantity * $sale_price - $gdn->quantity * $sale_price * 0.05,
                );
                $total += $arr['total'];
                $tax += $arr['tax'];
                $subtotal += $arr['amount'];

                array_push($saleItems, $arr);

            }

            foreach($saleItems as $saleItem){
                $gdn = \App\Models\Gdn::findOrFail($saleItem['gdn_id']);
                unset($saleItem['gdn_id']);
                $newSaleItem = \App\Models\SaleItem::create($saleItem);
                //update Gdn and Sale order item by sale item id
                $gdn->soItem->update(['sale_item_id' => $newSaleItem->id]);
                $gdn->update(['sale_item_id' => $newSaleItem->id]);
            }

            $sale->update(['total' => $total, 'tax' => $tax, 'sub_total' => $subtotal]);

            //update sale order by sale id.
            foreach($completedSaleOrders as $completedSaleOrder){
                $completedSaleOrder->update(['sale_id' => $sale->id]);
            }

            // Make sale complete
            if(!empty($sale)){
                $sale->update(['status' => 0]); // complete
            }

       //------------------------------------ Section 8: End


    }

    private static function doSomething($respectiveBundle, $usedQuantity)
    {
        // Find the respective StockItem of that bundle
        $width =  $respectiveBundle->stockItem->width;
        $stock_color =  $respectiveBundle->stockItem->stock_color_id;
        $stock_item = \App\Models\StockItem::where('stock_color_id', $stock_color)->where( 'width', $width)->first();

        // update stockitem quantity
        $stock_item->update(['quantity' => $stock_item->quantity - $usedQuantity]);

        // dispatch stockitem update event
        // on every stock item update event, stockColor will update himself, via relation
        $stock_item->stockColor->update(['quantity' => $stock_item->stockColor->quantity - $usedQuantity]);

        // dispatch stockColor update event
        // on every stock color update event, stock will update himself, via relation
        $stock_item->stockColor->stock->update(['quantity' => $stock_item->stockColor->stock->quantity - $usedQuantity]);
    
        //Stock Transaction
        $selfInstance = new self(); 
        $selfInstance->call(
            StockTransactionSeeder::class ::transactionUpdate(
                'App\Models\Gdn', 
                $respectiveBundle,
                $usedQuantity,
                $stock_item
            )
        );
        // End of Stock Transaction
    
    }
    
}
