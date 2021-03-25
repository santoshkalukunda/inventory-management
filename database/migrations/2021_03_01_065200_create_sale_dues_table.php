<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_dues', function (Blueprint $table) {
            $table->id();
            $table->uuid('bill_id')->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('date')->nullable();
            $table->double('due_amount')->nullable();
            $table->double('payment')->nullable();
            $table->double('due')->nullable();
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
        Schema::dropIfExists('sale_dues');
    }
}
