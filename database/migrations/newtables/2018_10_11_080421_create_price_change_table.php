<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_change', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->decimal('old_price',18,2);
            $table->decimal('new_price',18,2);
            $table->string('change_date')->nullable();
            $table->integer('user_id');
            $table->integer('recordstatus')->default(1);
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
        Schema::dropIfExists('price_change');
    }
}
