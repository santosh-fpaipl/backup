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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained(); // Customer Id
            $table->foreignId('stock_id')->constrained();
            $table->foreignId('sale_id')->nullable()->constrained();
            // MC/SO0424/0001
            $table->string('so_id')->unique(); 
            $table->float('variation')->default(0.05);
            $table->float('rate')->default(0.00);
            $table->longText('payment_terms')->nullable();
            $table->longText('delivery_terms')->nullable();
            $table->longText('quality_terms')->nullable();
            $table->longText('general_terms')->nullable();

            $table->boolean('pre_order')->default(false); // if stock is not available to fulfill this request then make it true
            $table->boolean('approved')->default(true); // Whenever you made any changes in either payment_terms or delivery_terms or quality_terms or general_terms, then it's value will be false.

            $table->unsignedBigInteger('accepter')->nullable();  // merchant manager id
            $table->timestamp('accepted_at')->nullable();

            // $table->unsignedBigInteger('approver')->nullable(); // manager id
            // $table->timestamp('approved_at')->nullable();

            $table->text('tags')->nullable();
            $table->boolean('pending')->default(1); // Either pending(default), completed
            $table->timestamps();
            $table->softDeletes(); // act as cancelled_at
        });

        // Schema::create('sale_order_history', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('sale_order_id')->constrained(); // Customer Id
        //     $table->float('rate')->default(0.00);
        //     $table->float('quantity')->default(0.00);
        //     $table->float('variation')->default(0.05);
        //     $table->longText('payment_terms')->nullable();
        //     $table->longText('delivery_terms')->nullable();
        //     $table->longText('quality_terms')->nullable();
        //     $table->longText('general_terms')->nullable();
        //     $table->unsignedBigInteger('changer')->nullable();  // purchase manager or supplier id
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('changer')
        //         ->references('id')
        //         ->on('users')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');
        // });

        Schema::create('so_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_order_id')->constrained();
            $table->foreignId('stock_color_id')->constrained(); // Red Cotton
            $table->foreignId('sale_item_id')->nullable()->constrained();
            $table->float('quantity')->default(0.00); // 100
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_items');
        Schema::dropIfExists('sale_order_history');
        Schema::dropIfExists('sale_orders');
    }
};
