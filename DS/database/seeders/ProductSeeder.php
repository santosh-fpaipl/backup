<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products =[
            [
                'name' => 'product1',
                'code' => 'product1',
                'moq' => 10,
                'hsncode' => 'AAA123',
                'gstrate' => 5,
                'options' => [
                    [
                        'name' => 'green',
                        'code' => 'green1',
                        'image' => public_path('storage\assets\fabric1a.jpg'),
                    ],
                    [
                        'name' => 'blue',
                        'code' => 'blue1',
                        'image' => public_path('storage\assets\fabric1b.jpg'),
                    ],
                ],
                'ranges' => [
                    [
                        'name' => 'S',
                        'code' => 'S1',
                        'mrp' => 100,
                        'price' => 80,
                    ],
                    [
                        'name' => 'M',
                        'code' => 'M1',
                        'mrp' => 200,
                        'price' => 160,
                    ],
                    [
                        'name' => 'L',
                        'code' => 'L1',
                        'mrp' => 300,
                        'price' => 240,
                    ],
                ],
            ],
            
        ];

        foreach($products as $product){

           // $this->command->info($product);

            $newProduct = \App\Models\Product::create([
                'name' => $product['name'],
                'code' => $product['code'],
                'moq' => $product['moq'],
                'hsncode' => $product['hsncode'],
                'gstrate' => $product['gstrate'],
                'tags' => $product['name'].",".$product['code'].",".$product['moq'].",".$product['hsncode'].",".$product['gstrate'],

            ]);

            foreach($product['options'] as $option){
                $product_option = \App\Models\Option::create([
                    'name' => $option['name'],
                    'code' => $option['code'],
                    'product_id' => $newProduct->id,
                ]);

                $product_option->addSingleMediaToModal($option['image']);
            }

            foreach($product['ranges'] as $range){
                \App\Models\Range::create([
                    'name' => $range['name'],
                    'code' => $range['code'],
                    'mrp' => $range['mrp'],
                    'price' => $range['price'],
                    'product_id' => $newProduct->id,
                ]);
            }
        }
    }
}
