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

        Schema::create('godowns', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // G1
            $table->string('contacts')->nullable();
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->float('used')->default(0.00);
            $table->integer('capacity')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // R1
            $table->float('used')->default(0.00);
            $table->integer('capacity')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // L1
            $table->float('used')->default(0.00);
            $table->integer('capacity')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // G1R2L1
            $table->foreignId('godown_id')->nullable()->constrained();
            $table->foreignId('rack_id')->constrained();
            $table->foreignId('level_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('godowns');
        Schema::dropIfExists('racks');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('locations');
    }
};