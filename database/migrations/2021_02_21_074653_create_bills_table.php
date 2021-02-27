<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date')->nullable();
            $table->foreignId('customer_id')->constrained('customers');
            $table->unsignedBigInteger('invoice_no')->nullable();
            $table->double('discount')->nullable();
            $table->double('vat')->nullable();
            $table->double('total')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
