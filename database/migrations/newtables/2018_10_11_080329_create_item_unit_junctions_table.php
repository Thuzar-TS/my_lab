<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemUnitJunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_unit_junctions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('description')->nullable();
            $table->decimal('ratio',18,2)->nullable();
            $table->char('measure_operator',1)->nullable();
            $table->decimal('specific_price',18,2)->nullable();
            $table->integer('item_level')->nullable();
            $table->decimal('profit_percent',18,2);
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
        Schema::dropIfExists('item_unit_junctions');
    }
}
