<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('symbol');
            $table->enum('side', ['buy', 'sell']); // @todo add this as an enum
            $table->decimal('price', 16, 8);
            $table->decimal('amount', 16, 8);
            $table->decimal('remaining', 16, 8);
            $table->enum('status', ['1', '2', '3'])->default('1'); // (open=1, filled=2, cancelled=3)

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
        Schema::dropIfExists('orders');
    }
}
