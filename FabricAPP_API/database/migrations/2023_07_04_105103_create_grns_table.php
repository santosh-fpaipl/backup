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
        /*
            GRN will done on respect to bundles not recpect to purchase
       */

        // Take few or all bundles from purchased items to create GRN
        // select un-grn'ed purchase -> items -> bundles(original)
        Schema::create('grns', function (Blueprint $table) {
            $table->id();
            $table->string('grnid')->unique(); // GRN2154564
            $table->foreignId('stock_color_id')->constrained(); // Red Cotton
            $table->float('quantity')->default(0.00); // sum of all related bundles 
            $table->boolean('draft')->default(true); // edit only in draft mode, make false when approved
            $table->string('status')->default('draft'); // draft, pending, qc, racking -> (now update stock)
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gdns', function (Blueprint $table) {
            $table->id();
            $table->string('gdnid')->unique(); // GDN2154564
            $table->foreignId('stock_color_id')->constrained(); // Red Cotton
            $table->foreignId('so_item_id')->constrained(); // 
            $table->float('width')->nullable(); // panna ex.- 1.45 mtr
            $table->float('quantity')->default(0.00); // sum of all related bundles 
            $table->boolean('draft')->default(true); // edit only in draft mode, make false when approved
            $table->string('status')->default('draft'); // draft, completed (when sale_item_id set)
            $table->foreignId('sale_item_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

         // On purchase live generate into seperate bundle
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_id')->nullable()->constrained();
            $table->foreignId('gdn_id')->nullable()->constrained();
            $table->foreignId('purchase_item_id')->nullable()->constrained();
            $table->foreignId('stock_color_id')->constrained();
            $table->foreignId('stock_item_id')->nullable()->constrained();
            $table->boolean('singleuse')->default(true); // false if bundle_usage is created
            $table->float('original')->default(0.00); // 120 original quantity
            $table->float('quantity')->default(0.00); // 110 approved quantity
            $table->float('available')->default(0.00); // 50, 60 available quantity, last related usage -> closing balance // either, 100->80->40->0
            $table->foreignId('location_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bundle_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained();
            $table->float('opening')->default(0.00); // approved 400
            $table->float('used')->default(0.00); // 100
            $table->float('closing')->default(0.00); // 300 i.e. available
            $table->foreignId('gdn_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

       
        Schema::create('qc_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_id')->constrained();
            $table->longText('data')->nullable(); // for display purpose only
            $table->boolean('draft')->default(true); // edit only in draft mode, make false when approved
            // $table->foreignId('staff_id')->constrained(); // qc done by
            //$table->foreignId('manager_id')->constrained(); // qc approved by
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grns');
        Schema::dropIfExists('gdns');
        Schema::dropIfExists('bundles');
        Schema::dropIfExists('bundle_usages');
        Schema::dropIfExists('qc_reports');
    }
};
