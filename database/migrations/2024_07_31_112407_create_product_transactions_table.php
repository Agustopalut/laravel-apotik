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
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('post_code');
            $table->string('phone_number');
            $table->string('proof');
            $table->string('city');
            $table->boolean('is_paid');
            $table->unsignedBigInteger('total_amount'); // artinya, harga tidak boleh bernilai negatif 
            $table->text('note');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
