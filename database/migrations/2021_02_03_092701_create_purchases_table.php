<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_bill_id')->constrained('purchase_bills');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('dealer_id')->constrained('dealers');
            $table->string('batch_no')->nullable();
            $table->string('mf_date')->nullable();
            $table->string('exp_date')->nullable();
            $table->double('quantity');
            $table->foreignId('unit_id')->constrained('units');
            $table->double('rate');
            $table->double('discount')->nullable();
            $table->double('vat')->nullable();
            $table->double('total');
            $table->double('mrp')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
