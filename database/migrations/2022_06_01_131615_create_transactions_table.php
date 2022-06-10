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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('sub_total',15,2)->dafault(0);
            $table->double('discount',15,2)->default(0);
            $table->double('grand_total',15,2)->default(0);
            $table->double('paid_amount',15,2)->default(0);
            $table->double('change_amount',15,2)->default(0);
            $table->unsignedBigInteger('payment_method_id')->default(1);  // the default payment method is "Cash" with ID 1
            $table->json('detail_product')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
