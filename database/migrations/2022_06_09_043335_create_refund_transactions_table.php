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
        Schema::create('refund_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->double('sub_total',15,2)->dafault(0);
            $table->double('discount',15,2)->default(0);
            $table->double('tax',15,2)->default(0);
            $table->double('grand_total',15,2)->default(0);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('refund_transactions');
    }
};
