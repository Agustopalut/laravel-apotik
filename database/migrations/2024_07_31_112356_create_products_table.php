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
            $table->string('name');
            $table->string('slug');
            $table->string('photo');
            $table->unsignedBigInteger('price'); // artinya, harga tidak boleh bernilai negatif 
            $table->string('about');
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
            // cascade artinya, ketika data dari category terhapus, maka daya penghubung nya juga terhapus
            // ini untuk mencegah adanya cacat
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
