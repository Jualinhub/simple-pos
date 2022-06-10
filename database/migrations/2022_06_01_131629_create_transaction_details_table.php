<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->double('amount')->default(1);
            $table->double('price',15,2)->default(0);
            $table->double('tax',15,2)->nullable();
            $table->double('discount',15,2)->dafault(0);
            $table->double('total',15,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
};
