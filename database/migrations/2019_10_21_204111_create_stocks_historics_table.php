<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks_historics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('symbol', 4);
            $table->decimal('open', 2);
            $table->decimal('close', 2);
            $table->decimal('high', 2);
            $table->decimal('low', 2);
            $table->decimal('change', 2);
            $table->float('changePercent');
            $table->date('date');
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
        Schema::dropIfExists('stocks_historics');
    }
}
