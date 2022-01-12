<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConfirmOrderMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmorders', function (Blueprint $table) {
            $table->id('orderid');
            $table->string('invoiceno');
            $table->integer('gtotal');
            $table->date('invoicedate');
            $table->string('status')->default('approved');
            $table->string('paymethod')->nullable();
            $table->string('txnid')->nullable();
            $table->string('cid')->nullable();
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
        Schema::dropIfExists('confirmorders');
    }
}
