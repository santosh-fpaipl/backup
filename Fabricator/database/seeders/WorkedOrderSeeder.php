<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http; // Import the Http facade

class WorkedOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workedOrders = [
            [
                'productId' => 2,
                'quantity' => 200,
                'quantities' => [
                    '1-1' => 200
                ],
                'stocks' => [
                    [
                        'id' => 1,
                        'colors' =>[
                            [
                                'id' => 1,
                                'required' => 200,
                                'received' => 200,
                                'unit' => 'mtr',
                                'rate' => 100,
                            ],   
                        ]
                    ],
                ],
            ],
        ];

        foreach($workedOrders as $workedOrder) {
            $response = Http::get('http://192.168.1.133:8000/api/internal/products/' . $workedOrder['productId']); // Replace with the actual API endpoint
            $product = $response->json(); // Convert the JSON response to an array
            //$this->command->info($product['images']);

            $newWorkedOrder = \App\Models\WorkedOrder::create([
                'productId' => $product['id'],
                'name' => $product['name'],
                'thumb' => $product['thumb'],
                'images' => json_encode($product['images']),
                'code' => $product['code'],
                'fcpu' => $product['fcpu'],
                'sizes' => json_encode($product['sizes']),
                'colors' => json_encode($product['colors']),
                'quantity' => $workedOrder['quantity'],
                'quantities' => json_encode($workedOrder['quantities']),
                'final' => json_encode($workedOrder['quantities']),
            ]);

            $newFabricProc = \App\Models\FabricProc::create([
                'worked_order_id' => $newWorkedOrder->id,
            ]);

            foreach($workedOrder['stocks'] as $stock){
                $newFabricProcItem = \App\Models\FabricProcItem::create([
                    'fabric_proc_id' => $newFabricProc->id,
                    'stock_id' => $stock['id'],
                ]);

                foreach($stock['colors'] as $color){
                    $amount = $color['received'] * $color['rate'];
                    $this->command->info($amount*2);
                    $gst = $amount * 0.05;

                    $this->command->info($gst);

                    $newFabricProcItemColor = \App\Models\FabricProcItemColor::create([
                        'fabric_proc_item_id' => $newFabricProcItem->id,
                        'stock_color_id' => $color['id'],
                        'required' => $color['required'],
                        'received' => $color['received'],
                        'unit' => $color['unit'],
                        'rate' => $color['rate'],
                        'amount' => round($amount, 2),
                        'gst' => round($gst, 2),
                        'total' => round($amount - $gst, 2),
                    ]);
                }
            }

            
            
        }
    }
}
