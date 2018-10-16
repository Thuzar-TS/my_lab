<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_code',50)->nullable();
            $table->string('description')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('item_type_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('packing')->nullable();
            $table->integer('lastvendor_id')->nullable();
            $table->string('expired_date')->nullable();
            $table->string('lastpurchase_date')->nullable();
            $table->string('lastsale_date')->nullable();
            $table->integer('inactive')->nullable();
            $table->integer('ismultilevel')->nullable();
            $table->integer('usebarcode')->nullable();
            $table->integer('useexpire')->nullable();
            $table->integer('sale_account_number')->nullable();
            $table->integer('purchase_account_number')->nullable();
            $table->integer('salereturn_account_number')->nullable();
            $table->integer('purchasereturn_account_number')->nullable();
            $table->string('img_path')->nullable();
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
        Schema::dropIfExists('items');
    }
}
