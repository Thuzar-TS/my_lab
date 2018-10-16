<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('header_id');
            $table->integer('line_number')->nullable();            
            $table->integer('item_id')->nullable();
            $table->integer('lab_id')->nullable();
            $table->string('description')->nullable();
            $table->decimal('qty',18,2)->nullable();
            $table->decimal('price',18,2)->nullable();
            $table->decimal('discount_amt',18,2)->nullable();
            $table->decimal('discount_percent',18,2)->nullable();
            $table->decimal('total_amt',18,2)->nullable();
            $table->decimal('original_price',18,2)->nullable();
            $table->decimal('referred_percent',18,2)->nullable();
            $table->decimal('referred_amt',18,2)->nullable();
            $table->integer('unit_id')->nullable();
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
        Schema::dropIfExists('slip_details');
    }
}
