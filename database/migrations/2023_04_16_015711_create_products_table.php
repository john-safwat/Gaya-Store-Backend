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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->unsignedBigInteger('category');
            $table->double('price',10 , 3);
            $table->string('mainImage',100)->nullable();
            $table->text('description')->nullable();
            $table->string('descriptionImage',100)->nullable();
            $table->unsignedBigInteger('brand');
            $table->float('quantity', 6 , 1);
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
