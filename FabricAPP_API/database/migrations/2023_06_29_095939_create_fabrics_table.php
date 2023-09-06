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
        // New
        // Schema::create('categories', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('parent_id')->nullable();
        //     $table->string('type'); // style, material
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->string('sid')->unique(); // 
        //     $table->text('description')->nullable();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('parent_id')
        //         ->references('id')
        //         ->on('categories')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');
        // });

        // Schema::create('styles', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('category_id')->constrained();
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->string('sid')->unique(); // 
        //     $table->text('description')->nullable();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('materials', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('category_id')->constrained();
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->string('sid')->unique(); // 
        //     $table->text('description')->nullable();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('fabrics', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('style_id')->nullable();
        //     $table->unsignedBigInteger('material_id')->nullable();
        //     $table->unique(['style_id', 'material_id']);
        //     $table->string('sid')->unique(); // 
        //     $table->json('data'); // all fields of material and style
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->float('gstrate')->default(0.00);
        //     $table->string('hsncode')->nullable();
        //     $table->string('unit'); // mtr, kg, inch, cm
        //     $table->text('description')->nullable();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('style_id')
        //         ->references('id')
        //         ->on('materials')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');

        //     $table->foreign('material_id')
        //         ->references('id')
        //         ->on('materials')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');
        // });

        // Schema::create('fabric_colors', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->string('sid')->unique(); //
        //     $table->foreignId('fabric_id')->constrained();
        //     $table->unique(['fabric_id', 'slug']);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Old
        // Schema::create('fabric_categories', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('parent_id')->nullable();
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->foreign('parent_id')
        //         ->references('id')
        //         ->on('fabric_categories')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');;
        // });

        // Schema::create('fabrics', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('fabric_category_id')->constrained();
        //     $table->string('name');
        //     $table->string('slug')->unique();
        //     $table->float('gstrate')->default(0.00);
        //     $table->string('hsncode')->nullable();
        //     $table->string('unit'); // mtr, kg, inch, cm
        //     $table->text('description')->nullable();
        //     $table->text('tags')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('fabric_colors', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('slug');
        //     $table->foreignId('fabric_id')->constrained();
        //     $table->unique(['fabric_id', 'slug']);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('styles');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('fabrics');
        Schema::dropIfExists('fabric_colors');
    }
};
