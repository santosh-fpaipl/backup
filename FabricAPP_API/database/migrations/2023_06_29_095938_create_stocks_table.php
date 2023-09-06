<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('type'); // style, material
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sid')->unique(); // 
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sid')->unique(); // 
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sid')->unique(); // 
            $table->string('unit'); // mtr, kg, inch, cm
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Will update after every change in stock color
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->float('quantity')->default(0.00); // total available bundles length for all colors and width
            $table->unsignedBigInteger('style_id')->nullable();
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unique(['style_id', 'material_id']);
            $table->string('sid')->unique(); // 
            $table->string('name');
            $table->string('slug')->unique();
            $table->float('sale_price')->default(0.00);
            $table->float('gstrate')->default(0.00);
            $table->string('hsncode')->nullable();
            $table->string('unit'); // mtr, kg, inch, cm
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('style_id')
                    ->references('id')
                    ->on('materials')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
    
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        // Diffrent color options for same stock
        Schema::create('stock_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained(); // Red Cotton
            $table->float('quantity')->default(0.00); // total available bundles length for all widths
            $table->text('tags')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('sid')->unique(); //
            $table->unique(['stock_id', 'slug']);
            $table->timestamps();
            $table->softDeletes();
        });

        // Diffrent width options for same stock color
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_color_id')->constrained();
            $table->float('min_rate')->default(0.00); // Minimum Selling Rate (Cant be less tahn this) // previously avg_rate
            $table->float('max_rate')->default(0.00); // Maximum Selling Rate (Cant be more than this)
            $table->float('quantity')->default(0.00); // sum of all related grns
            $table->float('width')->default(0); // panna ex.- 2 mtr, 2.5 mtr
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['stock_color_id','width']);
        });

        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('transactionable');
            $table->foreignId('stock_item_id')->constrained(); // Red Cotton
            $table->float('opening')->default(0.00);
            $table->float('quantity')->default(0.00); 
            $table->float('closing')->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('styles');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('stock_colors');
        Schema::dropIfExists('stock_items');
        Schema::dropIfExists('stock_transactions');
    }
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