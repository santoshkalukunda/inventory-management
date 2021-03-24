<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_bills', function (Blueprint $table) {
            $table->id();
            $table->string('order_date')->nullable();
            $table->string('shipping_date')->nullable();
            $table->foreignId('dealer_id')->constrained('dealers');
            $table->string('bill_no')->nullable();
            $table->double('total')->nullable();
            $table->double('discount')->nullable();
            $table->double('vat')->nullable();
            $table->double('net_total')->nullable();
            $table->double('payment')->nullable();
            $table->double('due')->nullable();
            $table->string('status');
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('purchase_bills');
    }
}
