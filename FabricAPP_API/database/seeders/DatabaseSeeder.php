<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TaxationSeeder;
use Database\Seeders\SizeSeeder;
use Database\Seeders\FabricApp;
use Database\Seeders\StockSeederPart1;
use Database\Seeders\StockSeederPart2;
use Database\Seeders\StockSeederPart3;
use App\Models\Address;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      // for($i=0; $i <= 10; $i++){
      //   $user = \App\Models\User::factory()->create();
      //   $this->command->info($user);
      //   \App\Models\Merchant::create([
      //     'user_id' => $user->id,
      //     'sid' =>'M1'.$user->id
      //   ]);
      // }

        //$this->call(FabricApp::class);

       $this->call(StockSeederPart1::class);
        $this->call(StockSeederPart2::class);
        //$this->call(StockSeederPart3::class);
    }
}
