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
        //Will update after every sale or purchase.
        //Represent available(current) quantity of fabric color.
        // Schema::create('stocks', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('fabric_color_id')->constrained(); // Red Cotton
        //     //Adjust in controller
        //     //if at the time of first purchase, force this 'last_sale_id' column value to be zero.
        //     $table->unsignedBigInteger('last_sale_id')->nullable();
        //     $table->unsignedBigInteger('last_purchase_id')->nullable();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('last_sale_id')
        //         ->references('id')
        //         ->on('sales')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');

        //     $table->foreign('last_purchase_id')
        //         ->references('id')
        //         ->on('purchases')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');
           
        // });

        // Schema::create('stock_items', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('stock_id')->constrained();
        //     $table->float('volume'); // Total bundle volume (total_bundle_acccumulated_length * width ) ex- 12,000 sq. mtr, 15,000 sq. mtr
        //     $table->longText('bundles_length')->nullable(); // ex: 50, 60, 40, 20.5 // (170.5) total_length of each bundle (in mtr)
        //     $table->float('total')->default(0.00); // Total Bundles Length
        //     $table->float('avg_rate')->default(0.00); // Average Rate
        //     $table->integer('quantity'); // Quantity- 3000, 2400  i.e number of piece (volume / (length*width)  )
        //     $table->float('width'); // panna ex.- 2 mtr, 2.5 mtr
        //     $table->float('length'); // layer(length of one piece) ex:- 2mtr, 2.5mtr
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->unique(['stock_id','width','length']);
        // });

        // Schema::create('transactions', function (Blueprint $table) {
        //     $table->id();
        //     $table->morphs('transactionable'); // Purchase or sale id
        //     $table->foreignId('fabric_color_id')->constrained(); // Red Cotton
        //     $table->float('width'); // panna ex.- 1.45 mtr
        //     $table->float('length'); // layer(length of one piece) ex:- 2 mtr
        //     $table->float('rate')->default(0.00); // Rs.45/mtr
        //     $table->float('amount')->default(0.00); // 170.5 mtr x Rs.45/mtr = Rs. 7,672.50/-
        //     $table->longText('bundles_length')->nullable(); // ex: 50, 60, 40, 20.5 // (170.5) total_length of each bundle (in mtr)
        //     $table->float('total')->default(0.00); // Total Bundles Length
        //     // Auto computed
        //     $table->float('volume'); // Total bundle volume (total of bundles_length * width ) ex- [170.5 * 1.45 = 247.22] sq. mtr
        //     $table->integer('quantity'); // Quantity- 247.22 / (1.45 * 2) = 85.24 i.e 85 number of piece (volume / (length*width)  )
        //     $table->boolean('draft')->default(true);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('stock_items');
    }
};
