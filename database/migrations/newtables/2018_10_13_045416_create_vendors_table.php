<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_name')->nullable();
            $table->integer('vendor_type_id')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();            
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->decimal('balance',18,2)->nullable();
            $table->integer('account_number')->nullable();
            $table->integer('purchase_account_number')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
