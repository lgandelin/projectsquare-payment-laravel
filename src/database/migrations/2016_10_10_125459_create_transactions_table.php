<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier');
            $table->decimal('amount', 5, 2)->nullable();
            $table->string('payment_mean')->nullable();
            $table->integer('status')->nullable();
            $table->string('response_code')->nullable();
            $table->integer('platform_id')->nullable();
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
        Schema::drop('transactions');
    }
}
