<?php

namespace Database\Seeders;

use App\Models\StockTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\StockTransactionSeeder;


class StockSeederPart1 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         *  Section 1: Start -------------------------
         */ 
            // Create Godowns, Racks, Levels 
            // Create locations using Godowns, Racks, Levels.

            $series = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
            $godowns = 3;
            $racks = 100;
            $levels = 4;

            for ($g=0; $g < $godowns; $g++) { 
                \App\Models\Godown::create([
                    'name' => $series[$g],
                ]);
            }

            for ($r=1; $r < $racks; $r++) { 
                \App\Models\Rack::create([
                    'name' => $r,
                ]);
            }

            for ($l=0; $l < $levels; $l++) { 
                \App\Models\Level::create([
                    'name' => $series[$l],
                ]);
            }
            
            foreach (\App\Models\Godown::all() as $godown) {
                foreach (\App\Models\Rack::all() as $rack) {
                    foreach (\App\Models\Level::all() as $level) { 
                        $rackName = $rack->name; 
                        if(strlen($rack->name) < 2){
                            $rackName = '0'.$rackName; 
                        }
                        //Create Locations using Godowns, Racks, Levels.
                        \App\Models\Location::create([
                            'name' => $godown->name . $rackName . $level->name,
                            'godown_id' => $godown->id,
                            'rack_id' => $rack->id,
                            'level_id' => $level->id,
                        ]);
                    }
                } 
            }

            //For creating Customer and Supplier

            $users = [
                [
                    'type' => 'supplier',
                    'name' => 'Santosh Singh',
                    'email' => 'santosh@example.com',
                ],
                [
                    'type' => 'customer',
                    'name' => 'Rajesh Singh',
                    'email' => 'rajesh@example.com',
                ],
                [
                    'type' => 'merchant',
                    'name' => 'Nikhil Singh',
                    'email' => 'nikhil@example.com',
                ],

            ];

            foreach($users as $user){

                $type = $user['type'];
                unset($user['type']);
                $newUser = \App\Models\User::factory()->create($user);

                if($type == 'supplier'){
                    \App\Models\Supplier::create([
                        'user_id' => $newUser->id,
                        'sid' =>'S11'
                    ]);
                } elseif($type == 'customer') {
                    \App\Models\Customer::create([
                        'user_id' => $newUser->id,
                        'sid' =>'C11'
                    ]);
                } elseif($type == 'merchant') {
                    \App\Models\Merchant::create([
                        'user_id' => $newUser->id,
                        'sid' =>'M11'
                    ]);
                }
                
            }

            //For creating category

            $categories = [
                [
                    'sid' => 'M11',
                    'type' => 'material',
                    'name' => 'Polyester',
                ],
                [
                    'sid' => 'M21',
                    'type' => 'material',
                    'name' => 'Cotton',
                ],
                [
                    'sid' => 'C21',
                    'type' => 'style',
                    'name' => 'Charectors',
                ],
                [
                    'sid' => 'C11',
                    'type' => 'style',
                    'name' => 'Priints',
                ]
            ];

            foreach ($categories as $category) {
                \App\Models\Category::create($category);
            }

            //For creating material and style

            $items = [
                [
                    'sid' => 'M001',
                    'category_id' => 1,
                    'type' => 'material',
                    'name' => 'snowfall',
                    'unit' => 'kg', // matrial
                ],
                [
                    'sid' => 'M002',
                    'category_id' => 2,
                    'type' => 'material',
                    'name' => 'Chiffon',
                    'unit' => 'kg', // matrial
                ],
                [
                    'sid' => 'S001',
                    'category_id' => 3,
                    'type' => 'style',
                    'name' => 'Micky',
                ],
                [
                    'sid' => 'S002',
                    'category_id' => 4,
                    'type' => 'style',
                    'name' => 'checks',
                ]
            ];

            foreach ($items as $item) {
                $type = $item['type'];
                unset($item['type']);
                if ($type == 'material') {
                    \App\Models\Material::create($item);
                } else if ($type == 'style') {
                    \App\Models\Style::create($item);
                }
            }    
            
            // For creating stock

            $stocks = [
                [
                    'material_id' => 1,
                    'style_id' => 1,
                    'unit' => 'kg', // pick from material->unit
                    'sid' => 'F001001', // includs material and style id
                    'name' => 'Snowfall Micky',
                    'sale_price' => 100,
                    'gstrate' => 5,
                    'hsncode' => '59039091',
                    'description' => 'test test test',
                ],
                [
                    'material_id' => 1,
                    'unit' => 'kg',
                    'style_id' => 2,
                    'sid' => 'F001002',
                    'name' => 'Snowfall Checks',
                    'sale_price' => 100,
                    'gstrate' => 5,
                    'hsncode' => '59039091',
                    'description' => 'test test test',
                ],
                [
                    'material_id' => 2,
                    'unit' => 'kg',
                    'style_id' => 1,
                    'sid' => 'F002001',
                    'name' => 'Chiffon Micky',
                    'sale_price' => 100,
                    'gstrate' => 5,
                    'hsncode' => '59039091',
                    'description' => 'test test test',
                ],
                [
                    'material_id' => 2,
                    'unit' => 'kg',
                    'style_id' => 2,
                    'sid' => 'F002002',
                    'name' => 'Chiffon Checks',
                    'sale_price' => 100,
                    'gstrate' => 5,
                    'hsncode' => '59039091',
                    'description' => 'test test test',
                ]
            ];

            foreach ($stocks as $stock) {
                \App\Models\Stock::create($stock);
            }

            //For creating stock color

            $stockColors = [
                [
                    'stock_id' => 1, // Snowfall Mickey
                    'sid' => 'F001001-Blue', // take stock sid and add color at end
                    'name' => 'Blue',
                    'image' => public_path('storage\assets\fabric1a.jpg'),
                ],
                [
                    'stock_id' => 1, // Snowfall Mickey
                    'sid' => 'F001001-Red',
                    'name' => 'Red',
                    'image' => public_path('storage\assets\fabric1b.jpg'),
                ],
                [
                    'stock_id' => 1, // Snowfall Mickey
                    'sid' => 'F001001-Green',
                    'name' => 'Green',
                    'image' => public_path('storage\assets\fabric1c.jpg'),
                ],
                [
                    'stock_id' => 2, // Snowfall Checks
                    'sid' => 'F001002-Blue',
                    'name' => 'Blue',
                    'image' => public_path('storage\assets\fabric1a.jpg'),
                ],
                [
                    'stock_id' => 2, // Snowfall Checks
                    'sid' => 'F001002-Red',
                    'name' => 'Red',
                    'image' => public_path('storage\assets\fabric1b.jpg'),
                ],
                [
                    'stock_id' => 3, // Chiffon Mickey
                    'sid' => 'F002001-Blue',
                    'name' => 'Blue',
                    'image' => public_path('storage\assets\fabric1c.jpg'),
                ],
                [
                    'stock_id' => 4, // Chiffon Checks
                    'sid' => 'F002002-Orange',
                    'name' => 'Orange',
                    'image' => public_path('storage\assets\fabric1b.jpg'),
                ],
            ];

            foreach ($stockColors as $stockColor) {
                $stockColorImage = $stockColor['image'];
                unset($stockColor['image']);
                $stockColor = \App\Models\StockColor::create($stockColor);
                $stockColor->addSingleMediaToModal($stockColorImage);
            }

        // ------------------- Section 1: End


        // Section 2: Start ------------------------

            //For creating Purchase Order and its items

            // One purchase order contains only one fabric i.e one stock
            // User will select stock
            $selectedStockId = 1;
            $stock = \App\Models\Stock::find($selectedStockId);

            $purchaseOrders = [
                [
                    'supplier_id' => 1,
                    'po_id' => 'MC/PO0823/0001',
                    'stock_id' => $stock->id, // Snowfall Mickey 
                    'rate' => 100,
                    'quantity' => 1500,
                    'variation' => '0.05',
                    'payment_terms' => 'test test',
                    'delivery_terms' =>'test test',
                    'quality_terms' => 'test test',
                    'general_terms' => 'test test',
                    'issuer' => 1, // merchant id
                    'duedate_at' =>'2023-08-13',
                ]
            ];

            foreach($purchaseOrders as $purchaseOrder){
                $newPO = \App\Models\PurchaseOrder::create($purchaseOrder);
                $stockColors = $stock->stockColors;
                foreach($stockColors as $stockColor){
                    \App\Models\PoItem::create([
                        'quantity' => round($newPO->quantity / $stockColors->count(),2),
                        'stock_color_id' => $stockColor->id,
                        'purchase_order_id' => $newPO->id
                    ]);
                }
            }

            //Make purchase Order Locked (User action required)
            $selectedPurchaseOrderId = 1;
            $purchaseOrder = \App\Models\PurchaseOrder::findOrFail($selectedPurchaseOrderId);
            $purchaseOrder->update(['locked' => 1]); // Locked

        // ----------------- Section 2: End


        // Section 3: Start -------------------------

            //For creating Purchase and its items
            //One purchase can contains Multiple purchase orders
            //Split the quantity into small bundles
            
            function splitNumber($total) {
                $part1 = rand(1, $total - 2);
                $part2 = rand(1, $total - $part1 - 1);
                $part3 = $total - $part1 - $part2;
                return [$part1, $part2, $part3];
            }

            $purchases = [
                [
                    'supplier_id' => 1,
                    'invoice_no' =>'12345678',
                    'invoice_date' =>'2023-08-01',
                    'description' =>'test test',
                ],
            ];

            foreach($purchases as $purchase){
                $newPurchase = \App\Models\Purchase::create($purchase);

                // Choose from locked pos to be included in this purchase
                if($newPO->pending){
                    exit;
                }
                $currentPo = $newPO;
                $currentPoItems = $newPO->poItems;

                $total = 0;

                foreach($currentPoItems as $currentPoItem){

                    $minRate = $currentPo->rate - ($currentPo->rate * $currentPo->variation);
                    $maxRate = $currentPo->rate + ($currentPo->rate * $currentPo->variation);
            
                    $minQty = $currentPoItem->quantity - ($currentPoItem->quantity * $currentPoItem->variation);
                    $maxQty = $currentPoItem->quantity + ($currentPoItem->quantity * $currentPoItem->variation);
            
                    $finalRate = rand($minRate, $maxRate);
                    $finalQty = rand($minQty, $maxQty); // quantity  
            
                    $bundles = splitNumber($finalQty);

                    $purchaseItem = \App\Models\PurchaseItem::create([
                        'purchase_id' => $newPurchase->id,
                        'purchase_order_id' => $currentPo->id,
                        'stock_color_id' => $currentPoItem->stockColor->id,
                        'width' => rand(45, 60),
                        'bundles_length' => implode(",", $bundles),
                        'rate' => $finalRate,
                        'total' => $finalQty, // quantity
                        'amount' => $finalRate * $finalQty,
                    ]);

                    $currentPoItem->update([
                        'purchase_item_id' => $purchaseItem->id,
                        'adjusted' => $currentPoItem->quantity -  $purchaseItem->total,
                    ]);

                    $total += $finalRate * $finalQty;
                }

                $taxAmount = round(($total * $currentPo->stock->gstrate) / 100, 2);
                $newPurchase->total = $total;
                $newPurchase->tax = $taxAmount;
                $newPurchase->sub_total = $total - $taxAmount;
                $newPurchase->save();
            }

            //Make purchase Order Complete (User action required)
            $selectedPurchaseOrderId = 1;
            $purchaseOrder = \App\Models\PurchaseOrder::findOrFail($selectedPurchaseOrderId);
            $purchaseOrder->update(['pending' => 0]); // Complete

            //Make purchase live
            $selectedPurchaseId = 1;
            $purchase = \App\Models\Purchase::findOrFail($selectedPurchaseId);
            $purchase->update(['status' => 0]); // live

            // This is used to get the all unique prder_order_id of selected purchase. 
            // so that we can change the status of purchase_order to complete.
            // $purchaseOrders = \App\Models\PurchaseItem::distinct()->select('purchase_order_id')->where('purchase_id', $purchase->id)->get();
        
            // foreach($purchaseOrders as $purchaseOrder){
            //     \App\Models\PurchaseOrder::findOrFail($purchaseOrder->purchase_order_id)->update(['pending' => 0]);
            // }

            //For Creating Bundles
            foreach($purchase->purchaseItems as $purchaseItem){
                foreach(explode(',', $purchaseItem->bundles_length) as $bundle){
                    \App\Models\Bundle::create([
                        'purchase_item_id' => $purchaseItem->id,
                        'stock_color_id' => $purchaseItem->stockColor->id,
                        'original' => $bundle,
                    ]);
                }

            }

        // ---------------------------- Section 3: End


        /**
         * Section 4: Start ------------------------
         * 
         * We create grn for any selected stock, but stock color-wise
         * It involves qc and racking
         * This sections ends after updating main stock
         */
            // Grn is created  against bundles of stock color of a selected stock and Selected stock must belong purchase item 
            //and it must have pending Grn Bundles.

            $selectedStockId = 1;
            $selectedStock = \App\Models\Stock::find($selectedStockId);

            foreach ($selectedStock->stockColors as $selectedStockColor) {

                $grn = \App\Models\Grn::create([
                    'grnid' =>'GRN00' . $selectedStock->id . $selectedStockColor->id,
                    'stock_color_id' => $selectedStockColor->id,
                ]);
            
                $total = 0;
        
                $count = $selectedStockColor->pendingGrnBundles()->count();
                $bundles = $selectedStockColor->pendingGrnBundles()->random(rand(1,  $count));
        
                foreach ($bundles as $bundle) {
                    $bundle->grn_id = $grn->id;
                    $bundle->update();
                    $total += $bundle->original;
                }

                $grn->quantity = $total;
                $grn->update();
        
                    //For QC, Qc is created against grn
                    $bundles = $grn->bundles;
                    foreach($bundles as $bundle){
                        if ($bundle->id % 2 === 0) {
                            $bundle->quantity = $bundle->original * 0.9;
                            $bundle->available = $bundle->original * 0.9;
                        } else {
                            $bundle->quantity = $bundle->original;
                            $bundle->available = $bundle->original;
                        }
                        $bundle->save();
                    }
                    
                    // Racking
                    $allLocations = \App\Models\Location::all();
                    foreach($bundles as $bundle){
                        $randomLocation = $allLocations->random(1)->first()->name;
                        $bundle->location_id = \App\Models\Location::where('name', $randomLocation)->first()->id;
                        $bundle->save();
                    }

                // First Make Grn Live
                $grn->update(['status' => 'live']);

                    // Then, Update Stock Items on event that its been live
                    foreach($bundles as $bundle){
                        $width =  $bundle->purchaseItem->width;
                        $stockColorId =  $bundle->purchaseItem->stock_color_id;
                        
                        $stock_item = \App\Models\StockItem::updateOrCreate(
                            ['stock_color_id' => $stockColorId, 'width' => $width]
                        );

                        $bundle->stock_item_id = $stock_item->id;
                        $bundle->save();

                        $stock_item->quantity = ($stock_item->quantity ?: 0) + $bundle->available;
                        $stock_item->save();

                        $stock_item->stockColor->quantity = ($stock_item->stockColor->quantity ?: 0) + $bundle->available;
                        $stock_item->stockColor->save();

                        $stock_item->stockColor->stock->quantity = ($stock_item->stockColor->stock->quantity ?: 0) + $bundle->available;
                        $stock_item->stockColor->stock->save();

                        //Stock Transaction
                            $this->call(
                                StockTransactionSeeder::class ::transactionUpdate(
                                    'App\Models\Grn', 
                                    $bundle,
                                    $bundle->available,
                                    $stock_item
                                )
                            );
                        // End of Stock Transaction
                    }

            }

        //-------------------------- Section 4 : End


    }

    
   
}


