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
        // Schema::create('items', function (Blueprint $table) {
        //     $table->id();
        //     $table->morphs('itemable');
        //     $table->foreignId('fabric_color_id')->constrained(); // Red Cotton
        //     $table->float('quantity')->default(0.00);
        //     $table->float('rate')->default(0.00);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
