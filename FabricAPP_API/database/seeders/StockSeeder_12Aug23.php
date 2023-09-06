<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $godowns = 3;
        $racks = 50;
        $levels = 4;

        for ($g=0; $g < $godowns; $g++) { 
            \App\Models\Godown::create([
                'name' => 'G' . $g,
            ]);
        }

        for ($r=0; $r < $racks; $r++) { 
            \App\Models\Rack::create([
                'name' => 'R' . $r,
            ]);
        }

        for ($l=0; $l < $levels; $l++) { 
            \App\Models\Level::create([
                'name' => 'L' . $l,
            ]);
        }
        
        foreach (\App\Models\Godown::all() as $godown) {
            foreach (\App\Models\Rack::all() as $rack) {
                foreach (\App\Models\Level::all() as $level) {     
                    \App\Models\Location::create([
                        'name' => $godown->name . $rack->name . $level->name,
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
                'unit' => 'kg', // pick from material->unit
                'style_id' => 1,
                'sid' => 'F001001',
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
            ],
            [
                'stock_id' => 1, // Snowfall Mickey
                'sid' => 'F001001-Red',
                'name' => 'Red',
            ],
            [
                'stock_id' => 1, // Snowfall Mickey
                'sid' => 'F001001-Green',
                'name' => 'Green',
            ],
            [
                'stock_id' => 2, // Snowfall Checks
                'sid' => 'F001002-Blue',
                'name' => 'Blue',
            ],
            [
                'stock_id' => 2, // Snowfall Checks
                'sid' => 'F001002-Red',
                'name' => 'Red',
            ],
            [
                'stock_id' => 3, // Chiffon Mickey
                'sid' => 'F002001-Blue',
                'name' => 'Blue',
            ],
            [
                'stock_id' => 4, // Chiffon Checks
                'sid' => 'F002002-Orange',
                'name' => 'Orange',
            ],
        ];

        foreach ($stockColors as $stockColor) {
            \App\Models\StockColor::create($stockColor);
        }

        //For creating Purchase Order and its items

        // One purchase order contains only one fabric i.e one stock

        $purchaseOrders = [
            [
                'supplier_id' => 1,
                'po_id' => 'MC/PO0823/0001',
                'stock_id' => 1, // Snowfall Mickey 
                'rate' => 100,
                'quantity' => 1500,
                'payment_terms' => 'test test',
                'delivery_terms' =>'test test',
                'quality_terms' => 'test test',
                'general_terms' => 'test test',
                'issuer' => 1, // merchant id
                'duedate_at' =>'2023-08-13',
            ]
        ];

        foreach($purchaseOrders as $purchaseOrder){
            \App\Models\PurchaseOrder::create($purchaseOrder);
        }

        $poItems = [
            [
                'purchase_order_id' => 1,
                'stock_color_id' => 1,
                'quantity' =>500,
            ],
            [
                'purchase_order_id' => 1,
                'stock_color_id' => 2,
                'quantity' =>500,
            ],
            [
                'purchase_order_id' => 1,
                'stock_color_id' => 3,
                'quantity' =>500,
            ]
        ];

        foreach($poItems as $poItem){
            \App\Models\PoItem::create($poItem);
        }

        //For creating Purchase and its items
        //One purchase can contains Multiple purchase orders

        $purchases = [
            [
                'supplier_id' => 1,
                'invoice_no' =>'12345678',
                'invoice_date' =>'2023-08-01',
                'total' =>237500,
                'tax' =>12500,
                'sub_total' =>250000,
                'description' =>'test test',
            ],
        ];

        foreach($purchases as $purchase){
            \App\Models\Purchase::create($purchase);
        }

        $purchaseItems = [
            [
                'purchase_id' => 1,
                'purchase_order_id' => 1,
                'stock_color_id' => 1,
                'width' => 50,
                'bundles_length' =>'90,115,95',
                'rate' => 100,
                'total' => 300,
                'amount' =>30000,
            ],
            [
                'purchase_id' => 1,
                'purchase_order_id' => 1,
                'stock_color_id' => 1,
                'width' => 55,
                'bundles_length' =>'110,90',
                'rate' => 100,
                'total' => 200,
                'amount' =>20000,
            ],
            [
                'purchase_id' => 1,
                'purchase_order_id' => 1,
                'stock_color_id' => 2,
                'width' => 56,
                'bundles_length' =>'110,90,105,95,100',
                'rate' =>200,
                'total' =>500,
                'amount' =>100000,
            ],
            [
                'purchase_id' => 1,
                'purchase_order_id' => 1,
                'stock_color_id' => 3,
                'width' => 56,
                'bundles_length' =>'110,90,105,95,100',
                'rate' =>200,
                'total' =>500,
                'amount' =>100000,
            ]
        ];

        foreach($purchaseItems as $purchaseItem){
            \App\Models\PurchaseItem::create($purchaseItem);
        }

        //Make purchase live

        $purchase = \App\Models\Purchase::findOrFail(1);
        $purchase->status = 0; // live
        $purchase->save();

        $purchaseOrders = \App\Models\PurchaseItem::distinct()->select('purchase_order_id')->get();
      
        foreach($purchaseOrders as $purchaseOrder){
            \App\Models\PurchaseOrder::findOrFail($purchaseOrder->purchase_order_id)->update(['pending' => 0]);
        }

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

        //For Creating GRN
        // Grn is created  against bundles of stock color

        $grnDatas =[
            [
                'grnid' =>'GRN111',
                'quantity' => 0,
                'stock_color_id' => 1,
            ],
            [
                'grnid' =>'GRN222',
                'quantity' => 0,
                'stock_color_id' => 2,
            ],
            [
                'grnid' =>'GRN333',
                'quantity' => 0,
                'stock_color_id' => 3,
            ]
        ];

        foreach($grnDatas as $grnData){

            $grn = \App\Models\Grn::create($grnData);
    
            $total = 0;
    
            //$bundles = \App\Models\Bundle::whereIn('id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15])->get();
            //$bundles = \App\Models\Bundle::whereNull('grn_id')->get();
    
            $stockColor = \App\Models\StockColor::find($grn->stock_color_id);
            $bundles = $stockColor->pendingGrnBundles()->take(15);
    
            $this->command->info($bundles);
    
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
                if (in_array($bundle->id, [1,5,9])) {
                    $bundle->quantity = $bundle->original * 0.9;
                    $bundle->available = $bundle->original * 0.9;
                } else {
                    $bundle->quantity = $bundle->original;
                    $bundle->available = $bundle->original;
                }
                $bundle->save();
            }
            
            // Racking
            foreach($bundles as $bundle){
                if ($bundle->id < 4) {
                    $bundle->location_id = \App\Models\Location::where('name', 'G1R3L2')->first()->id;
                } elseif ($bundle->id < 6) {
                    $bundle->location_id = \App\Models\Location::where('name', 'G2R1L1')->first()->id;
                } elseif ($bundle->id < 15) {
                    $bundle->location_id = \App\Models\Location::where('name', 'G1R6L3')->first()->id;
                }
                $bundle->save();
            }

             // First Make Grn Live

            \App\Models\Grn::findOrFail($grn->id)->update(['status' => 'live']);

            // Then, Update Stock Items on event that its been live

            $grn = \App\Models\Grn::findOrFail($grn->id);
            $bundles = $grn->bundles;
            foreach($bundles as $bundle){
                $width =  $bundle->purchaseItem->width;
                $stock_color =  $bundle->purchaseItem->stock_color_id;
                
                $stock_item = \App\Models\StockItem::updateOrCreate(
                    ['stock_color_id' => $stock_color, 'width' => $width]
                );

                $bundle->stock_item_id = $stock_item->id;
                $bundle->save();

                $stock_item->quantity = ($stock_item->quantity ?: 0) + $bundle->available;
                $stock_item->save();

                $stock_item->stockColor->quantity = ($stock_item->stockColor->quantity ?: 0) + $bundle->available;
                $stock_item->stockColor->save();

                $stock_item->stockColor->stock->quantity = ($stock_item->stockColor->stock->quantity ?: 0) + $bundle->available;
                $stock_item->stockColor->stock->save();
            }

        }

        // catelog 1
        // --fabric 1
        // -- --color a - 140 mtr [115, 95-25] 
        // -- --color b - 190 mtr [110, 105-80] 
        // -- --color c - 140 mtr [110, 105-30]

        // catelog 2
        // --fabric 1
        // -- --color a - 140 mtr
        // -- --color b - 100 mtr
        // --fabric 2
        // -- --color a - 80 mtr
        // -- --color b - 60 mtr
        
        //For creating Sale Order and its items
        //One sale order may contains many fabrics i.e one catalog

        $saleOrders = [
            [
                'customer_id' => 1,
                'so_id' => 'MC/SO0823/0001',
                'payment_terms' => 'test test',
                'delivery_terms' =>'test test',
                'quality_terms' => 'test test',
                'general_terms' => 'test test',
                'items' => [
                    [
                        'stock_color_id' => 1,
                        'quantity' =>140,
                    ],
                    [
                        'stock_color_id' => 2,
                        'quantity' =>190,
                    ],
                    [
                        'stock_color_id' => 3,
                        'quantity' =>140,
                    ],
                ],
            ],
            [
                'customer_id' => 1,
                'so_id' => 'MC/SO0823/0002',
                'payment_terms' => 'test test',
                'delivery_terms' =>'test test',
                'quality_terms' => 'test test',
                'general_terms' => 'test test',
                'items' => [
                    [
                        'stock_color_id' => 1,
                        'quantity' =>140,
                    ],
                    [
                        'stock_color_id' => 2,
                        'quantity' =>100,
                    ],
                    [
                        'stock_color_id' => 4,
                        'quantity' =>80,
                    ],
                    [
                        'stock_color_id' => 5,
                        'quantity' =>60,
                    ],
                ],
            ]
        ];

        foreach($saleOrders as $saleOrder){
            $salesItems = $saleOrder['items'];
            unset($saleOrder['items']);
            $newSale = \App\Models\SaleOrder::create($saleOrder);

            foreach ($salesItems as $soItem) {
                $soItem['sale_order_id'] = $newSale->id;
                $newSoItem = \App\Models\SoItem::create($soItem);
                $pre_order = 0;
                if(!$pre_order){
                    /**
                    *  It sum the all the quantity of all the sale items of pending sale orders. if the quantity is greater than than the stock quantity, then set the current sale order as pre order (1) otherwise normal(pre order (1))
                    */
                    $pendingQuantity = \App\Models\SaleOrder::join('so_items', 'sale_orders.id', '=', 'so_items.sale_order_id')
                                    ->where('sale_orders.pending', 1)
                                    ->where('so_items.stock_color_id', $soItem['stock_color_id'])
                                    ->sum('so_items.quantity');
    
                    if($pendingQuantity > $newSoItem->stockColor->quantity){
                        $pre_order = 1;
                        $newSale->pre_order = 1;
                        $newSale->save();
                    }
                   // $this->command->info($pendingQuantity);
                }
            }
        }

        // TODO:
        // convert pre-order into normal order, when stock is updated, via an event

        //For Creating GDN 
        //Each GDN belong to only one sale order and one fabric

        $activeSaleOrder = \App\Models\SaleOrder::normal()->pending()->first();

        foreach ($activeSaleOrder->soItems as $activeSaleOrderItem) {
            $gdn = \App\Models\Gdn::create([
                'gdnid' => 'GDN11' . $activeSaleOrderItem->id,
                'sale_order_id' => $activeSaleOrder->id,
                'stock_color_id' => $activeSaleOrderItem->stockColor->id,
            ]);

            foreach ($activeSaleOrderItem->stockColor->stockItems as $sItem) {
                
                $requiredQuantity = $activeSaleOrderItem->quantity;

                if($activeSaleOrderItem->stockColor->id == 1 ){

                    $selectedBundle1 = $sItem->bundles->where('available', 115)->first();
                    $selectedBundle2 = $sItem->bundles->where('available', 95)->first();
                    $split = 25;

                } else if($activeSaleOrderItem->stockColor->id == 2){

                    $selectedBundle1 = $sItem->bundles->where('available',110)->first();
                    $selectedBundle2 = $sItem->bundles->where('available',105)->first();
                    $split = 80;

                }else if($activeSaleOrderItem->stockColor->id == 3){

                    $selectedBundle1 = $sItem->bundles->where('available', 110)->first();
                    $selectedBundle2 = $sItem->bundles->where('available', 105)->first();
                    $split = 30;
                }

                // todo


                $this->command->info( $selectedBundle1->available);
                $this->command->info( $selectedBundle2->available);
               // $split = $requiredQuantity - $selectedBundle1->available;
                // 25 = 140 - 115
                $balance = $selectedBundle2->available - $split;
                // 10 = 35 - 25

                $selectedBundle1->gdn_id = $gdn->id;
                $selectedBundle1->available = 0;
                $selectedBundle1->save();

                $selectedBundle2->gdn_id = $gdn->id; // last usage
                $selectedBundle2->available = $balance;
                $selectedBundle2->singleuse = 0;
                $selectedBundle2->save();

                \App\Models\BundleUsage::create([
                    'bundle_id' => $selectedBundle2->id,
                    'opening' => $selectedBundle2->available,
                    'used' => $split, 
                    'closing' => $balance,
                    'gdn_id' => $gdn->id,
                ]);

                $gdn->width = $sItem->width;
                // get all gdn->bundles
                // loop on each
                // if bundle is singleuse ->quantity (add to $sum)
                // else bundle->usage->where('gdn_id', $gdn->id)->usage (add to $sum)
                // finally $gdn->quantity = $sum

                $bundles = $gdn->bundles;
                $bundleQuantity = 0;

                foreach($bundles as $bundle){
                    if($bundle->singleuse){
                        $bundleQuantity = $bundle->quantity;
                    } else {
                        $bundleUsages = $bundle->bundleUsages()->where('gdn_id', $gdn->id)->get();
                        foreach($bundleUsages as $bundleUsage){
                            $bundleQuantity += $bundleUsage->used;
                        }
                    }
                }

                $gdn->quantity = $bundleQuantity;
                $gdn->save();

               break;
            }
        }

        // Complete
        \App\Models\SaleOrder::findOrFail($activeSaleOrder->id)->update(['pending' => 0]);

       // Gdn Live
        \App\Models\Gdn::where('sale_order_id',$activeSaleOrder->id)->update(['status' => 'live']);

       // Update Stock Items on event that its been live
        $gdns = \App\Models\Gdn::where('sale_order_id', $activeSaleOrder->id)->get();
        foreach($gdns as $gdn){
            $bundles = $gdn->bundles;
            foreach($bundles as $bundle){

                $bundleQuantity = 0;

                if($bundle->singleuse){
                    $bundleQuantity = $bundle->quantity;
                } else {
                    $bundleUsages = $bundle->bundleUsages()->where('gdn_id', $gdn->id)->get();
                    foreach($bundleUsages as $bundleUsage){
                        $bundleQuantity += $bundleUsage->used;
                    }
                }

                $width =  $bundle->stockItem->width;
                $stock_color =  $bundle->stockItem->stock_color_id;
                $stock_item = \App\Models\StockItem::where('stock_color_id', $stock_color)->where( 'width', $width)->first();
                   
                // there is posibality that we have issued fabric that not in stock
                
                // update stockitem
                $stock_item->quantity = $stock_item->quantity - $bundleQuantity;
                $stock_item->save();
                // dispatch stockitem update event
                // on every stock item update event, stockColor will update himself, via relation
                $stock_item->stockColor->quantity = $stock_item->stockColor->quantity - $bundleQuantity;
                $stock_item->stockColor->save();
                // dispatch stockColor update event
                // on every stock color update event, stock will update himself, via relation
                $stock_item->stockColor->stock->quantity = $stock_item->stockColor->stock->quantity - $bundleQuantity;
                $stock_item->stockColor->stock->save();
            }
        }
        

        //Create Sale and Sale Items
        //One Sale can contains multiple sale orders.

        $sale = [
                'customer_id' => 1,
                'invoice_no' =>'12345678',
                'invoice_date' =>'2023-08-10',
                'description' =>'test test',
        ];

        $sale = \App\Models\Sale::create($sale);

        $saleOrder = \App\Models\SaleOrder::findOrFail(1);
        $gdns = $saleOrder->gdns;

        $saleItems = array();
        $subtotal = 0;
        $tax = 0;
        $total = 0;

        foreach($gdns as $gdn){
            $sale_price = $gdn->stockColor->stock->sale_price;

            $arr = array(
                'sale_id' => $sale->id,
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
            \App\Models\SaleItem::create($saleItem);
        }

        \App\Models\Sale::findOrFail(1)->update(['total' => $total, 'tax' => $tax, 'sub_total' => $subtotal]);


        // Make sale live
         $sale = \App\Models\Sale::findOrFail($sale->id);
         $sale->status = 0; // live
         $sale->save();

    }
}
