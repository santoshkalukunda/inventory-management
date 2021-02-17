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
            $table->string('bill_no');
            $table->string('date');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('purchase_id')->constrained('purchases');
            $table->double('quantity');
            $table->foreignId('unit_id')->constrained('units');
            $table->double('rate');
            $table->double('discount')->nullable();
            $table->double('vat')->nullable();
            $table->double('total');
            $table->double('payment');
            $table->double('due');
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
        Schema::dropIfExists('sales');
    }
}
