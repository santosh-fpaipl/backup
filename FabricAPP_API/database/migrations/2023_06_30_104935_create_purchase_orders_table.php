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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained(); // Supplier Id
            // MC/PO0424/0001
            $table->string('po_id')->unique(); 
            $table->foreignId('stock_id')->constrained(); // Cotton
            $table->float('rate')->default(0.00);
            $table->float('quantity')->default(0.00); // sum of all items quantity
            $table->float('variation')->default(0.05);
            $table->longText('payment_terms')->nullable();
            $table->longText('delivery_terms')->nullable();
            $table->longText('quality_terms')->nullable();
            $table->longText('general_terms')->nullable();

            $table->boolean('approved')->default(true); // Whenever you made any changes in either payment_terms or delivery_terms or quality_terms or general_terms, then it's value will be false.

            $table->unsignedBigInteger('issuer')->nullable();  // merchant manager id
            
            $table->unsignedBigInteger('approver')->nullable(); // purchase manager id
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('duedate_at')->nullable();
            $table->text('tags')->nullable();
            $table->boolean('locked')->default(0); // Editable only when unlocked.
            $table->boolean('pending')->default(1); // Either pending(default), completed
            $table->timestamps();
            $table->softDeletes(); // act as cancelled_at
        });

        Schema::create('purchase_order_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained(); // Supplier Id
            $table->float('rate')->default(0.00);
            $table->float('quantity')->default(0.00);
            $table->float('variation')->default(0.05);
            $table->longText('payment_terms')->nullable();
            $table->longText('delivery_terms')->nullable();
            $table->longText('quality_terms')->nullable();
            $table->longText('general_terms')->nullable();
            $table->unsignedBigInteger('changer')->nullable();  // purchase manager or supplier id
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('changer')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
        });

        

        // Create fake purchase to add opening stock if any.
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained(); // Supplier Id
            $table->string('invoice_no')->unique();
            $table->string('invoice_date');
            $table->float('total')->default(0.00);
            $table->float('tax')->default(0.00);
            $table->float('sub_total')->default(0.00);
            $table->boolean('payment_status')->default(1); // True means paid and false means unpaid
            $table->boolean('delivery_status')->default(1); // True means delivered and false means undelivered
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->boolean('status')->default(1); // Either draft(default), live
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained();
            $table->foreignId('purchase_order_id')->constrained();
            $table->foreignId('stock_color_id')->constrained(); // Red Cotton
            $table->float('width'); // panna ex.- 1.45 mtr
            $table->longText('bundles_length')->nullable(); // ex: 50, 60, 40, 20.5 // (170.5) total_length of each bundle (in mtr)
            $table->float('rate')->default(0.00); // Rs.45/mtr
            $table->float('total')->default(0.00); // 170.5 mtr Total Bundles Length
            $table->float('amount')->default(0.00); // (total x rate) 170.5 mtr x Rs.45/mtr = Rs. 7,672.50/-
            $table->timestamps();
            $table->softDeletes();
            // Not used in version 2.0
            //$table->float('length')->default(1.00); // layer(length of one piece) ex:- 2 mtr
           // $table->float('volume')->nullable(); // Total bundle volume (total of bundles_length * width ) ex- [170.5 * 1.45 = 247.22] sq. mtr
            //$table->integer('quantity')->nullable(); // Quantity- 247.22 / (1.45 * 2) = 85.24 i.e 85 number of piece (volume / (length*width)  )
        });

        Schema::create('po_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained();
            //Used to connect purchased item against this po items for human referrence based on which merchat will decide whether its complete or not..
            $table->foreignId('purchase_item_id')->nullable()->constrained(); 
            $table->foreignId('stock_color_id')->constrained(); // Red Cotton
            $table->float('quantity')->default(0.00); // 100
            $table->decimal('adjusted')->nullable(); //  Difference between purchase item quantity and PO item quantity.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_items');
        Schema::dropIfExists('purchase_order_history');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('purchase_items');
    }
};
