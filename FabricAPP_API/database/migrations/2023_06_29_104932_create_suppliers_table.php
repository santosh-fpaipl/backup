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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('address_id')->nullable()->constrained(); // Billing Address Id
            $table->string('alias')->nullable();
            $table->string('contacts')->nullable();
            $table->string('gst')->nullable();
            $table->string('pan')->nullable();
            $table->string('sid')->unique(); //
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
