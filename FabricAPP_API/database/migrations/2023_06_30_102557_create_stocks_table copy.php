<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     //Will update after every change in stock color
    //     //Represent available(current) quantity of fabric.
    //     Schema::create('stocks', function (Blueprint $table) {
    //         $table->id();
    //         $table->float('quantity')->default(0.00); // total available bundles length for all colors and width
    //         // before
    //        // $table->foreignId('fabric_id')->constrained(); // Cotton
    //         // after
    //         $table->unsignedBigInteger('style_id')->nullable();
    //         $table->unsignedBigInteger('material_id')->nullable();
    //         $table->unique(['style_id', 'material_id']);
    //         $table->string('sid')->unique(); // 
    //         $table->string('name');
    //         $table->string('slug')->unique();
    //         $table->float('gstrate')->default(0.00);
    //         $table->string('hsncode')->nullable();
    //         $table->string('unit'); // mtr, kg, inch, cm
    //         $table->text('description')->nullable();
    //         $table->text('tags')->nullable();
    //         // Adjust in controller
    //         // if at the time of first purchase, force this 'last_sale_id' column value to be zero.
    //         // $table->foreignId('sale_id')->nullable()->constrained(); // last_sale_id
    //         // $table->foreignId('purchase_id')->nullable()->constrained(); // last_purchase_id
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });

    //     // Diffrent color options for same fabric
    //     Schema::create('stock_colors', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('stock_id')->constrained(); // Red Cotton
    //         $table->float('quantity')->default(0.00); // total available bundles length for all widths
    //         $table->text('tags')->nullable();
    //         // before
    //         // $table->foreignId('fabric_color_id')->constrained(); // Red Cotton
    //         // after
    //         $table->string('name');
    //         $table->string('slug')->unique();
    //         $table->string('sid')->unique(); //
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });

    //     // Diffrent width options for same fabric color
    //     Schema::create('stock_items', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('stock_color_id')->constrained();
    //         $table->float('min_rate')->default(0.00); // Minimum Selling Rate (Cant be less tahn this) // previously avg_rate
    //         $table->float('max_rate')->default(0.00); // Maximum Selling Rate (Cant be more than this)
    //         $table->integer('quantity')->default(0); // sum of all related grns
    //         $table->float('width')->default(0); // panna ex.- 2 mtr, 2.5 mtr
    //         $table->timestamps();
    //         $table->softDeletes();
    //         $table->unique(['stock_color_id','width']);
    //     });

    //    /*
    //         GRN will done on respect to bundles not recpect to purchase
    //    */

    //     // Take few or all bundles from purchased items to create GRN
    //     // select un-grn'ed purchase -> items -> bundles(original)
    //     Schema::create('grns', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('grn_id')->unique(); // GRN2154564
    //         $table->foreignId('stock_item_id')->nullable()->constrained();
    //         $table->float('quantity')->default(0.00); // sum of all related bundles 
    //         $table->boolean('draft')->default(true); // edit only in draft mode, make false when approved
    //         $table->string('status')->default('draft'); // draft, pending, qc, racking -> (now update stock)
    //         $table->timestamps();
    //     });

    //      // On purchase live generate into seperate bundle
    //      Schema::create('bundles', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('grn_id')->nullable()->constrained();
    //         $table->foreignId('purchase_item_id')->constrained();
    //         $table->boolean('approved')->default(true);
    //         $table->float('original')->default(0.00); // 120 original quantity
    //         $table->float('quantity')->default(0.00); // 110 approved quantity
    //         $table->float('available')->default(0.00); // 50, 60 available quantity, last related usage -> closing balance // either, 100->80->40->0
    //         $table->foreignId('location_id')->nullable()->constrained();
    //         $table->timestamps();
    //     });

    //     // create only for partly used bundles
    //     // [ 100, 0, 100 ]
    //     // [ 100, 20, 80 ]
    //     // [ 80, 40, 40 ]
    //     // [ 40, 40, 0 ]
    //     Schema::create('bundle_usages', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('bundle_id')->constrained();
    //         $table->float('opening')->default(0.00); // approved 400
    //         $table->float('used')->default(0.00); // 100
    //         $table->float('closing')->default(0.00); // 300 i.e. available
    //         $table->foreignId('sale_item_id')->constrained();
    //         $table->timestamps();
    //     });

       
    //     Schema::create('qc_reports', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('grn_id')->constrained();
    //         $table->longText('data')->nullable(); // for display purpose only
    //         $table->boolean('draft')->default(true); // edit only in draft mode, make false when approved
    //         // $table->foreignId('staff_id')->constrained(); // qc done by
    //         //$table->foreignId('manager_id')->constrained(); // qc approved by
    //         $table->timestamps();
    //     });
       
    // }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('stocks');
    //     Schema::dropIfExists('stock_colors');
    //     Schema::dropIfExists('stock_items');
    //     Schema::dropIfExists('bundles');
    //     Schema::dropIfExists('bundle_usages');
    //     Schema::dropIfExists('grns');
    //     Schema::dropIfExists('qc_reports');
    // }
};


/*

purchase

purchase items

live

budles(original:100) -> bundles_usage(opening:0)

qc -> bundles list -> grn

sno. | bundle name    |  original  
 
1.   bundle a             100    
2.   bundle b             100    
3.   bundle c             100    
4.   bundle d             100    
5.   bundle e             100    
6.   bundle f             100    
7.   bundle g             100    


grn -> qc_report

sno. | bundle id    |  original  |  approved  |  rejected | remarks | prepared by
 
1.   bundle a             100         80            20       misprint    pandey
2.   bundle b             100         80            20       misprint    pandey
3.   bundle c             100         80            20       misprint    pandey
4.   bundle d             100         80            20       misprint    pandey
5.   bundle e             100         80            20       misprint    pandey
6.   bundle f             100         80            20       misprint    pandey
7.   bundle g             100         80            20       misprint    pandey

grn -> racking

sno. | bundle name    |  approved  |  godown | rack | level  |  racked by 
 
1.   bundle a              80           g1      r1      l1       salman  
2.   bundle b              80           g1      r1      l1       salman    
3.   bundle c              80           g1      r1      l1       salman    
4.   bundle d              80           g1      r1      l1       salman    
5.   bundle e              80           g1      r1      l1       salman    
6.   bundle f              80           g1      r1      l1       salman    
7.   bundle g              80           g1      r1      l1       salman    

 */