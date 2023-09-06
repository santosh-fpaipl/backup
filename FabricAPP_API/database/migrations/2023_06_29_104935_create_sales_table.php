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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained(); // Supplier Id
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
            // $table->foreignId('billing_address_id')->constrained(); // Billing Address Id
            // $table->foreignId('shipping_address_id')->constrained(); // Shipping Address Id
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained();
            $table->float('quantity'); // total of related gdn's
            $table->float('rate')->default(0.00); // Rs.45/mtr
            $table->float('total')->default(0.00); // $table->float('total')->default(0.00); // Rs. 7,672.50/-
            $table->float('tax')->default(0.00); // $total * $tax_rate
            $table->float('amount')->default(0.00); // $total - $tax
            $table->timestamps();
            $table->softDeletes();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
    }
};
