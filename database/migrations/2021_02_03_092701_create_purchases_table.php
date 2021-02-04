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
            $table->string('date');
            $table->string('bill_no');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('dealer_id')->constrained('dealers');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('model_no')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('mf_date')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('quantity');
            $table->foreignId('unit_id')->constrained('units');
            $table->string('rate');
            $table->string('discount')->nullable();
            $table->string('vat')->nullable();
            $table->string('total');
            $table->string('payment');
            $table->string('due');
            $table->string('mrp')->nullable();
            $table->text('details')->nullable();
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
