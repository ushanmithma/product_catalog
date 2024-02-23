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
            $table->string('code', 12)->unique();
            $table->string('category', 40);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('selling_price', 13, 2);
            $table->decimal('special_price', 13, 2)->nullable();
            $table->enum('status', ['Draft', 'Published', 'Out of Stock'])->default('Draft');
            $table->boolean('is_delivery_available');
            $table->string('image', 100);
            $table->timestamps();
            $table->softDeletes();
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
