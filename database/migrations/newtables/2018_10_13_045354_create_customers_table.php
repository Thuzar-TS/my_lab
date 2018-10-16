<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();            
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->decimal('balance',18,2)->nullable();
            //$table->int('account_number');
           // $table->int('purchase_account_number');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
