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
        Schema::create('worked_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productId');
            $table->string('name');
            $table->string('thumb');
            $table->json('images')->nullable();
            $table->string('code')->nullable();
            $table->integer('quantity');
            $table->string('stage')->default('aaa');
            $table->string('status')->default(1);
            $table->boolean('locked')->default(1);
            $table->string('fcpu')->nullable();
            $table->json('sizes');
            $table->json('colors')->nullable();
            $table->json('quantities');
            $table->json('final');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fabric_procs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worked_order_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fabric_proc_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_proc_id')->constrained();
            $table->unsignedBigInteger('stock_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fabric_proc_item_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_proc_item_id')->constrained();
            $table->unsignedBigInteger('stock_color_id')->nullable();
            $table->float('required')->defaul(0.00); //length
            $table->float('received')->defaul(0.00);
            $table->string('unit');
            $table->float('rate')->default(0.00);
            $table->float('amount')->default(0.00);
            $table->float('gst')->default(0.00);
            $table->float('total')->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worked_orders');
        Schema::dropIfExists('fabric_procs');
        Schema::dropIfExists('fabric_proc_items');
        Schema::dropIfExists('fabric_proc_item_colors');
    }
};
