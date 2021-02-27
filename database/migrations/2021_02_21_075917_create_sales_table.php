<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->uuid('bill_id')->nullable();
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('store_id')->constrained('stores');
            $table->double('quantity');
            $table->foreignId('unit_id')->constrained('units');
            $table->double('rate');
            $table->double('total_cost');
            $table->double('discount')->nullable();
            $table->double('vat')->nullable();
            $table->double('total');
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
        Schema::dropIfExists('sales');
    }
}
