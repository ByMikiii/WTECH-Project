<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('manufacturer');
            $table->enum('gender', ['Men', 'Women', 'Unisex']);
            $table->string('color');
            $table->string('type');
            $table->double('price');
            $table->boolean('isSale')->default(false);
            $table->double('salePrice');
            $table->date('release_date');
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
