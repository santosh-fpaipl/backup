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
        Schema::create('job_work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('fabricator_id');
            $table->string('jwoi')->unique(); //created manually job work order id
            $table->integer('quantity')->default(0);
            $table->json('quantities');
            $table->text('message')->nullable();
            $table->date('expected_at');
            $table->string('status')->default('issued'); //issued,accepted,completed,cancelled
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_work_orders');
    }
};
