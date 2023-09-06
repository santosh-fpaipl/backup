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
        // Schema::create('stock_histories', function (Blueprint $table) {
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
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
