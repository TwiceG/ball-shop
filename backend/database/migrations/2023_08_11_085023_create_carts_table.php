<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable(); // Allow NULL values
            $table->unsignedBigInteger('user_id');
            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 2)->nullable()->default(null); // Allow NULL values
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }


    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
